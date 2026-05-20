<?php

namespace App\Services\Syllabus;

use App\Models\SyllabusVersion;

class SyllabusDiffService
{
    public function buildDiff(
        SyllabusVersion $oldVersion,
        SyllabusVersion $newVersion
    ): array {

        return [
            'course_objectives' => $this->diffCourseObjectives(
                $oldVersion,
                $newVersion
            ),

            'course_learning_outcomes' => $this->diffCourseLearningOutcomes(
                $oldVersion,
                $newVersion
            ),

            'teaching_plan' => $this->diffTeachingPlan(
                $oldVersion,
                $newVersion
            ),

            'sections' => $this->diffSections(
                $oldVersion,
                $newVersion
            ),
        ];
    }

    private function diffCourseObjectives(
        SyllabusVersion $oldVersion,
        SyllabusVersion $newVersion
    ): array {

        $changes = [];

        $oldItems = $oldVersion->courseObjectives
            ->keyBy('code');

        $newItems = $newVersion->courseObjectives
            ->keyBy('code');

        foreach ($newItems as $code => $newItem) {

            $oldItem = $oldItems->get($code);

            if (!$oldItem) {

                $changes[] = [
                    'code' => $code,
                    'change_type' => 'added',
                    'old' => null,
                    'new' => $newItem->description,
                ];

                continue;
            }

            $similarity = $this->textDiffRatio(
                $oldItem->description,
                $newItem->description
            );

            if ($similarity < 1.0) {

                $changes[] = [
                    'code' => $code,
                    'change_type' => 'updated',
                    'old' => $oldItem->description,
                    'new' => $newItem->description,
                    'similarity' => $similarity,
                    'change_ratio' => round(1 - $similarity, 2),
                ];
            }
        }

        return $changes;
    }

    private function diffCourseLearningOutcomes(
        SyllabusVersion $oldVersion,
        SyllabusVersion $newVersion
    ): array {

        $changes = [];

        $oldItems = $oldVersion->courseLearningOutcomes
            ->keyBy('code');

        $newItems = $newVersion->courseLearningOutcomes
            ->keyBy('code');

        foreach ($newItems as $code => $newItem) {

            $oldItem = $oldItems->get($code);

            if (!$oldItem) {

                $changes[] = [
                    'code' => $code,
                    'change_type' => 'added',
                    'old' => null,
                    'new' => $newItem->description,
                ];

                continue;
            }

            $hasChanged =
                trim($oldItem->description)
                !== trim($newItem->description)
                ||
                trim($oldItem->bloom_level ?? '')
                !== trim($newItem->bloom_level ?? '');

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
                ];
            }
        }

        return $changes;
    }

    private function diffTeachingPlan(
        SyllabusVersion $oldVersion,
        SyllabusVersion $newVersion
    ): array {

        $changes = [];

        $oldItems = $oldVersion->teachingPlanItems
            ->keyBy('item_order');

        $newItems = $newVersion->teachingPlanItems
            ->keyBy('item_order');

        foreach ($newItems as $order => $newItem) {

            $oldItem = $oldItems->get($order);

            if (!$oldItem) {

                $changes[] = [
                    'order' => $order,
                    'change_type' => 'added',
                    'title' => $newItem->title,
                ];

                continue;
            }

            $hasChanged =
                json_encode($oldItem->content)
                !== json_encode($newItem->content)
                ||
                json_encode($oldItem->learning_activities)
                !== json_encode($newItem->learning_activities)
                ||
                json_encode($oldItem->assessment_activities)
                !== json_encode($newItem->assessment_activities);

            if ($hasChanged) {

                $changes[] = [
                    'order' => $order,
                    'change_type' => 'updated',
                    'title' => $newItem->title,
                ];
            }
        }

        return $changes;
    }

    private function diffSections(
        SyllabusVersion $oldVersion,
        SyllabusVersion $newVersion
    ): array {

        $changes = [];

        $oldItems = $oldVersion->contents
            ->keyBy('section_id');

        $newItems = $newVersion->contents
            ->keyBy('section_id');

        foreach ($newItems as $sectionId => $newItem) {

            $oldItem = $oldItems->get($sectionId);

            if (!$oldItem) {

                $changes[] = [
                    'section_id' => $sectionId,
                    'change_type' => 'added',
                ];

                continue;
            }

            if (
                trim(strip_tags($oldItem->content_html ?? ''))
                !== trim(strip_tags($newItem->content_html ?? ''))
            ) {

                $changes[] = [
                    'section_id' => $sectionId,
                    'change_type' => 'updated',
                    'section_title' => $newItem->section->title ?? '',
                ];
            }
        }

        return $changes;
    }

    private function textDiffRatio(
        ?string $old,
        ?string $new
    ): float {

        $old = trim(strip_tags($old ?? ''));
        $new = trim(strip_tags($new ?? ''));

        if ($old === '' && $new === '') {
            return 1.0;
        }

        similar_text($old, $new, $percent);

        return round($percent / 100, 2);
    }
}
