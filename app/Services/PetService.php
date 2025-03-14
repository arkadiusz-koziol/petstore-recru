<?php

namespace App\Services;

use App\Config\PetStoreConfig;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class PetService
{
    public function __construct(private PetStoreConfig $config)
    {
    }

    public function handleCreatePet(array $data): array
    {
        return $this->createPet($this->transformData($data));
    }

    public function createPet(array $data): array
    {
        return Http::post("{$this->config->apiUrl()}/pet", $this->preparePayload($data))->json();
    }

    public function updatePet(array $data): array
    {
        return Http::put("{$this->config->apiUrl()}/pet",
            $this->preparePayload(
                $this->transformData($data)
            )
        )->json();
    }

    public function deletePet(int $petId): array
    {
        return Http::delete("{$this->config->apiUrl()}/pet/{$petId}")->json();
    }

    public function findPetById(int $petId): ?array
    {
        try {
            $response = Http::get("{$this->config->apiUrl()}/pet/{$petId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (Exception $e) {
            Log::error('Error fetching pet data from API', [
                'petId' => $petId,
                'exception' => $e
            ]);

            return null;
        }
    }

    private function transformData(array $data): array
    {
        $data['category']['id'] = (int)($data['category']['id']);

        $data['photoUrls'] = isset($data['photoUrls'])
            ? array_filter(array_map('trim', explode("\n", $data['photoUrls'])))
            : [];

        // ID probably set by API
        $data['tags'] = isset($data['tags'])
            ? array_map(fn($tag) => ['id' => 0, 'name' => trim($tag)], explode("\n", $data['tags']))
            : [];

        return $data;
    }

    private function preparePayload(array $data): array
    {
        return [
            'id' => $data['id'] ?? 0,
            'category' => [
                'id' => $data['category']['id'],
                'name' => $data['category']['name'],
            ],
            'name' => $data['name'],
            'photoUrls' => $data['photoUrls'] ?? [],
            'tags' => $this->formatTags($data['tags'] ?? []),
            'status' => $data['status'],
        ];
    }

    private function formatTags(array $tags): array
    {
        return array_map(fn($tag) => ['name' => $tag], $tags);
    }
}
