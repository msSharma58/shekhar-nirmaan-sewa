<?php
function projectImg(?string $imageUrl, string $fallback = ''): string
{
    if (!$imageUrl) return $fallback;
    if (Str::startsWith($imageUrl, ['http://', 'https://'])) return $imageUrl;
    return Storage::url($imageUrl);
}
