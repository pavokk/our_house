<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateUniqueSlugTrait
{
    public static function bootGenerateUniqueSlugTrait(): void
    {
        static::saving(function ($model) {
            $slug = $model->slug;
            $model->slug = $model->generateUniqueSlug($slug);
        });
    }

    public function generateUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $slugNumber = null;

        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            $slugNumber = $matches[1];
            $slug = Str::replaceLast("-$slugNumber", '', $slug);
        }

        // Check if the modified slug already exists in the table
        $existingSlugs = $this->getExistingSlugs($slug, $this->getTable());

        if (!in_array($originalSlug, $existingSlugs)) {
            // Slug is unique
            return  $slug . ($slugNumber ? "-$slugNumber" : '');
        }

        // Increment until unique slug is found
        $i = $slugNumber ? ($slugNumber + 1) : 1;
        do {
            $newSlug = "{$slug}-{$i}";
            $i++;
        } while (in_array($newSlug, $existingSlugs));

        return $newSlug;
    }

    private function getExistingSlugs(string $slug, string $table): array
    {
        return $this->where('slug', 'LIKE', $slug . '%')
            ->where('id', '!=', $this->id ?? null)
            ->pluck('slug')
            ->toArray();
    }
}