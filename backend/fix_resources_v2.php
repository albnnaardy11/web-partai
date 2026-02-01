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

    // Fix imports
    $content = preg_replace('/use Filament\\\\Forms\\\\Form;/', 'use Filament\Schemas\Schema;', $content);
    
    // Fix function signatures
    $content = preg_replace('/public static function form\(Form \$form\): Form/', 'public static function form(Schema $form): Schema', $content);

    // Ensure use Filament\Actions; exists and no Actions namespace usage conflict
    if (!str_contains($content, 'use Filament\Actions;')) {
        $content = str_replace('use Filament\Tables\Table;', "use Filament\Tables\Table;\nuse Filament\Actions;", $content);
    }

    // Fix EditAction::make() etc if they are using Tables\Actions
    $content = str_replace('Tables\Actions\EditAction', 'Actions\EditAction', $content);
    $content = str_replace('Tables\Actions\BulkActionGroup', 'Actions\BulkActionGroup', $content);
    $content = str_replace('Tables\Actions\DeleteBulkAction', 'Actions\DeleteBulkAction', $content);

    file_put_contents($path, $content);
    echo "Fixed $resource\n";
}
