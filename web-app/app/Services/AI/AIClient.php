<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class AIClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ai_service.url');
    }

    public function generateCO(array $payload): array
    {
        return $this->post('/api/ai/generate-co', $payload);
    }

    public function generateCLO(array $payload): array
    {
        return $this->post('/api/ai/generate-clo', $payload);
    }

    public function generateTeachingPlan(array $payload): array
    {
        return $this->post('/api/ai/generate-teaching-plan', $payload);
    }

    private function post(string $endpoint, array $payload): array
    {
        $response = Http::timeout(120)
            ->post($this->baseUrl . $endpoint, $payload);

        if (!$response->successful()) {
            throw new \Exception(
                $response->json('details')
                    ?? $response->json('error')
                    ?? 'AI service error'
            );
        }

        return $response->json();
    }

    public function generateSmartDiff(array $payload): array
    {
        return $this->post('/api/ai/generate-smart-diff', $payload);
    }
}
