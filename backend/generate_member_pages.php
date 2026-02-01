<?php

$name = 'Member';
$resourceClass = "{$name}Resource";
$baseDir = __DIR__ . "/app/Filament/Resources/$resourceClass/Pages";

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0777, true);
}

// List
$listContent = "<?php

namespace App\Filament\Resources\\{$resourceClass}\Pages;

use App\Filament\Resources\\{$resourceClass};
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class List{$name}s extends ListRecords
{
    protected static string \$resource = {$resourceClass}::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
";
file_put_contents("$baseDir/List{$name}s.php", $listContent);

// Create
$createContent = "<?php

namespace App\Filament\Resources\\{$resourceClass}\Pages;

use App\Filament\Resources\\{$resourceClass};
use Filament\Resources\Pages\CreateRecord;

class Create{$name} extends CreateRecord
{
    protected static string \$resource = {$resourceClass}::class;
}
";
file_put_contents("$baseDir/Create{$name}.php", $createContent);

// Edit
$editContent = "<?php

namespace App\Filament\Resources\\{$resourceClass}\Pages;

use App\Filament\Resources\\{$resourceClass};
use Filament\Resources\Pages\EditRecord;

class Edit{$name} extends EditRecord
{
    protected static string \$resource = {$resourceClass}::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
";
file_put_contents("$baseDir/Edit{$name}.php", $editContent);

echo "Pages for $name generated.";
?>
