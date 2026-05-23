<?php

namespace App\Services\Syllabus;

use App\Models\SyllabusVersion;

class SyllabusDiffService
{
    public function buildDiff(
        SyllabusVersion $oldVersion,
        SyllabusVersion $newVersion
    ): array {
        $oldVersion->loadMissing([
            'courseObjectives',
            'courseLearningOutcomes',
            'teachingPlanItems.cloMappings',
            'contents.section',
        ]);

        $newVersion->loadMissing([
            'courseObjectives',
            'courseLearningOutcomes',
            'teachingPlanItems.cloMappings',
            'contents.section',
        ]);

        return [
            'course_objectives' => $this->diffCourseObjectives($oldVersion, $newVersion),
            'course_learning_outcomes' => $this->diffCourseLearningOutcomes($oldVersion, $newVersion),
            'teaching_plan' => $this->diffTeachingPlan($oldVersion, $newVersion),
            'sections' => $this->diffSections($oldVersion, $newVersion),
        ];
    }

    private function diffCourseObjectives(SyllabusVersion $oldVersion, SyllabusVersion $newVersion): array
    {
        $changes = [];

        $oldItems = $oldVersion->courseObjectives->keyBy('code');
        $newItems = $newVersion->courseObjectives->keyBy('code');

        foreach ($newItems as $code => $newItem) {
            $oldItem = $oldItems->get($code);

            if (!$oldItem) {
                $changes[] = [
                    'code' => $code,
                    'change_type' => 'added',
                    'old' => null,
                    'new' => [
                        'description' => $newItem->description,
                        'bloom_level' => $newItem->bloom_level,
                    ],
                ];
                continue;
            }

            $descriptionSimilarity = $this->textDiffRatio(
                $oldItem->description,
                $newItem->description
            );

            $hasChanged =
                trim($oldItem->description ?? '') !== trim($newItem->description ?? '')
                || trim((string) $oldItem->bloom_level) !== trim((string) $newItem->bloom_level);

            if ($hasChanged) {
                $changes[] = [
                    'code' => $code,
                    'change_type' => 'updated',
                    'old' => [
                        'description' => $oldItem->description,
                        'bloom_level' => $oldItem->bloom_level,
                    ],
                    'new' => [
                        'description' => $newItem->description,
                        'bloom_level' => $newItem->bloom_level,
                    ],
                    'similarity' => $descriptionSimilarity,
                    'change_ratio' => round(1 - $descriptionSimilarity, 2),
                ];
            }
        }

        foreach ($oldItems as $code => $oldItem) {
            if (!$newItems->has($code)) {
                $changes[] = [
                    'code' => $code,
                    'change_type' => 'removed',
                    'old' => [
                        'description' => $oldItem->description,
                        'bloom_level' => $oldItem->bloom_level,
                    ],
                    'new' => null,
                ];
            }
        }

        return $changes;
    }

    private function diffCourseLearningOutcomes(SyllabusVersion $oldVersion, SyllabusVersion $newVersion): array
    {
        $changes = [];

        $oldItems = $oldVersion->courseLearningOutcomes->keyBy('code');
        $newItems = $newVersion->courseLearningOutcomes->keyBy('code');

        foreach ($newItems as $code => $newItem) {
            $oldItem = $oldItems->get($code);

            if (!$oldItem) {
                $changes[] = [
                    'code' => $code,
                    'change_type' => 'added',
                    'old' => null,
                    'new' => [
                        'description' => $newItem->description,
                        'bloom_level' => $newItem->bloom_level,
                    ],
                ];
                continue;
            }

            $descriptionSimilarity = $this->textDiffRatio(
                $oldItem->description,
                $newItem->description
            );

            $hasChanged =
                trim($oldItem->description ?? '') !== trim($newItem->description ?? '')
                || trim((string) $oldItem->bloom_level) !== trim((string) $newItem->bloom_level);

            if ($hasChanged) {
                $changes[] = [
                    'code' => $code,
                    'change_type' => 'updated',
                    'old' => [
                        'description' => $oldItem->description,
                        'bloom_level' => $oldItem->bloom_level,
                    ],
                    'new' => [
                        'description' => $newItem->description,
                        'bloom_level' => $newItem->bloom_level,
                    ],
                    'similarity' => $descriptionSimilarity,
                    'change_ratio' => round(1 - $descriptionSimilarity, 2),
                ];
            }
        }

        foreach ($oldItems as $code => $oldItem) {
            if (!$newItems->has($code)) {
                $changes[] = [
                    'code' => $code,
                    'change_type' => 'removed',
                    'old' => [
                        'description' => $oldItem->description,
                        'bloom_level' => $oldItem->bloom_level,
                    ],
                    'new' => null,
                ];
            }
        }

        return $changes;
    }

    private function diffTeachingPlan(SyllabusVersion $oldVersion, SyllabusVersion $newVersion): array
    {
        $changes = [];

        $oldItems = $oldVersion->teachingPlanItems->keyBy('item_order');
        $newItems = $newVersion->teachingPlanItems->keyBy('item_order');

        foreach ($newItems as $order => $newItem) {
            $oldItem = $oldItems->get($order);

            if (!$oldItem) {
                $changes[] = [
                    'order' => $order,
                    'change_type' => 'added',
                    'title' => $newItem->title,
                    'old' => null,
                    'new' => $this->formatTeachingPlanItem($newItem),
                ];
                continue;
            }

            $oldCloCodes = $this->getCloCodes($oldItem);
            $newCloCodes = $this->getCloCodes($newItem);

            $changedFields = [];

            if (trim($oldItem->title ?? '') !== trim($newItem->title ?? '')) {
                $changedFields[] = 'title';
            }

            if ($this->normalizeJson($oldItem->content) !== $this->normalizeJson($newItem->content)) {
                $changedFields[] = 'content';
            }

            if ($this->normalizeJson($oldItem->teaching_activities) !== $this->normalizeJson($newItem->teaching_activities)) {
                $changedFields[] = 'teaching_activities';
            }

            if ($this->normalizeJson($oldItem->learning_activities) !== $this->normalizeJson($newItem->learning_activities)) {
                $changedFields[] = 'learning_activities';
            }

            if ($this->normalizeJson($oldItem->assessment_activities) !== $this->normalizeJson($newItem->assessment_activities)) {
                $changedFields[] = 'assessment_activities';
            }

            if ($oldCloCodes !== $newCloCodes) {
                $changedFields[] = 'clo_mappings';
            }

            if (!empty($changedFields)) {
                $changes[] = [
                    'order' => $order,
                    'change_type' => 'updated',
                    'changed_fields' => $changedFields,
                    'old' => $this->formatTeachingPlanItem($oldItem),
                    'new' => $this->formatTeachingPlanItem($newItem),
                ];
            }
        }

        foreach ($oldItems as $order => $oldItem) {
            if (!$newItems->has($order)) {
                $changes[] = [
                    'order' => $order,
                    'change_type' => 'removed',
                    'title' => $oldItem->title,
                    'old' => $this->formatTeachingPlanItem($oldItem),
                    'new' => null,
                ];
            }
        }

        return $changes;
    }

    private function diffSections(SyllabusVersion $oldVersion, SyllabusVersion $newVersion): array
    {
        $changes = [];

        $oldItems = $oldVersion->contents->keyBy('section_id');
        $newItems = $newVersion->contents->keyBy('section_id');

        foreach ($newItems as $sectionId => $newItem) {
            $oldItem = $oldItems->get($sectionId);

            if (!$oldItem) {
                $changes[] = [
                    'section_id' => $sectionId,
                    'change_type' => 'added',
                    'section_title' => $newItem->section->title ?? '',
                    'old' => null,
                    'new' => $this->cleanText($newItem->content_html),
                ];
                continue;
            }

            $oldText = $this->cleanText($oldItem->content_html);
            $newText = $this->cleanText($newItem->content_html);

            if ($oldText !== $newText) {
                $similarity = $this->textDiffRatio($oldText, $newText);

                $changes[] = [
                    'section_id' => $sectionId,
                    'change_type' => 'updated',
                    'section_title' => $newItem->section->title ?? '',
                    'old' => $oldText,
                    'new' => $newText,
                    'similarity' => $similarity,
                    'change_ratio' => round(1 - $similarity, 2),
                ];
            }
        }

        foreach ($oldItems as $sectionId => $oldItem) {
            if (!$newItems->has($sectionId)) {
                $changes[] = [
                    'section_id' => $sectionId,
                    'change_type' => 'removed',
                    'section_title' => $oldItem->section->title ?? '',
                    'old' => $this->cleanText($oldItem->content_html),
                    'new' => null,
                ];
            }
        }

        return $changes;
    }

    private function formatTeachingPlanItem($item): array
    {
        return [
            'title' => $item->title,
            'content' => $item->content,
            'teaching_activities' => $item->teaching_activities,
            'learning_activities' => $item->learning_activities,
            'assessment_activities' => $item->assessment_activities,
            'clo_codes' => $this->getCloCodes($item),
        ];
    }

    private function getCloCodes($item): array
    {
        return $item->cloMappings
            ->pluck('clo_code')
            ->sort()
            ->values()
            ->toArray();
    }

    private function normalizeJson($value): string
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $value = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function cleanText(?string $html): string
    {
        return trim(preg_replace('/\s+/', ' ', strip_tags($html ?? '')));
    }

    private function textDiffRatio(?string $old, ?string $new): float
    {
        $old = $this->cleanText($old);
        $new = $this->cleanText($new);

        if ($old === '' && $new === '') {
            return 1.0;
        }

        similar_text($old, $new, $percent);

        return round($percent / 100, 2);
    }
}
