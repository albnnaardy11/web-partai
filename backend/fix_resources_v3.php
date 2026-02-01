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
    if (!file_exists($path)) {
        // Try to move from backup
        $backup = __DIR__ . "/resources_backup/$resource.php";
        if (file_exists($backup)) {
            copy($backup, $path);
            // Also copy Pages
            $name = str_replace('Resource', '', $resource);
            $pagesDir = "$baseDir/$resource/Pages";
            if (!is_dir($pagesDir)) mkdir($pagesDir, 0777, true);
            foreach (['List'.$name.'s', 'Create'.$name, 'Edit'.$name] as $page) {
                $pagePath = "$pagesDir/$page.php";
                $pageBackup = __DIR__ . "/resources_backup/$page.php"; // Wait, my backup script put them all in one dir
                if (file_exists($pageBackup)) copy($pageBackup, $pagePath);
            }
        } else { continue; }
    }

    $content = file_get_contents($path);

    // Fix imports - Remove conflicting Actions import
    $content = preg_replace('/use Filament\\\\Actions;\n?/', '', $content);
    $content = preg_replace('/use Filament\\\\Forms\\\\Form;/', 'use Filament\Schemas\Schema;', $content);
    
    // Fix function signatures
    $content = preg_replace('/public static function form\(Form \$form\): Form/', 'public static function form(Schema $form): Schema', $content);
    $content = preg_replace('/public static function form\(Schema \$form\): Schema/', 'public static function form(Schema $form): Schema', $content);

    // Fix navigation properties
    $content = preg_replace('/protected static \?string \$navigationIcon = /', 'protected static string | \BackedEnum | null $navigationIcon = ', $content);
    $content = preg_replace('/protected static \?string \$navigationGroup = /', 'protected static string | \UnitEnum | null $navigationGroup = ', $content);

    // Use absolute paths for Actions
    $content = str_replace('Tables\Actions\EditAction', '\Filament\Actions\EditAction', $content);
    $content = str_replace('Tables\Actions\BulkActionGroup', '\Filament\Actions\BulkActionGroup', $content);
    $content = str_replace('Tables\Actions\DeleteBulkAction', '\Filament\Actions\DeleteBulkAction', $content);
    $content = str_replace('Actions\EditAction', '\Filament\Actions\EditAction', $content);
    $content = str_replace('Actions\BulkActionGroup', '\Filament\Actions\BulkActionGroup', $content);
    $content = str_replace('Actions\DeleteBulkAction', '\Filament\Actions\DeleteBulkAction', $content);

    file_put_contents($path, $content);
    echo "Fixed $resource\n";
    
    // Also fix Pages
    $pagesDir = "$baseDir/$resource/Pages";
    if (is_dir($pagesDir)) {
        foreach (scandir($pagesDir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $pagePath = "$pagesDir/$file";
            $pageContent = file_get_contents($pagePath);
            $pageContent = preg_replace('/use Filament\\\\Actions;\n?/', '', $pageContent);
            $pageContent = str_replace('Actions\CreateAction', '\Filament\Actions\CreateAction', $pageContent);
            $pageContent = str_replace('Actions\EditAction', '\Filament\Actions\EditAction', $pageContent);
            $pageContent = str_replace('Actions\DeleteAction', '\Filament\Actions\DeleteAction', $pageContent);
            file_put_contents($pagePath, $pageContent);
        }
    }
}
