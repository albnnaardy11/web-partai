<?php

$resources = [
    'ValueResource',
    'ProgramResource',
    'RegionStatResource',
    'ArticleResource',
    'GalleryItemResource',
    'SiteSettingResource'
];

$baseDir = __DIR__ . '/app/Filament/Resources';

foreach ($resources as $resource) {
    $path = "$baseDir/$resource.php";
    if (!file_exists($path)) continue;

    $content = file_get_contents($path);

    // Fix double slashes
    $content = str_replace('\Filament\\\\Filament\Actions', '\Filament\Actions', $content);
    $content = str_replace('\Filament\\\Filament\Actions', '\Filament\Actions', $content); // in case of 3 slashes

    file_put_contents($path, $content);
    echo "Fixed $resource\n";
    
    // Also fix Pages
    $pagesDir = "$baseDir/$resource/Pages";
    if (is_dir($pagesDir)) {
        foreach (scandir($pagesDir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $pagePath = "$pagesDir/$file";
            $pageContent = file_get_contents($pagePath);
            $pageContent = str_replace('\Filament\\\\Filament\Actions', '\Filament\Actions', $pageContent);
            file_put_contents($pagePath, $pageContent);
        }
    }
}
