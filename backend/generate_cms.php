<?php

$baseDir = __DIR__ . '/app/Filament/Resources';

$resources = [
    'Value' => [
        'icon' => 'heroicon-o-star',
        'form' => "Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\Textarea::make('description')->required(),
                   Forms\Components\FileUpload::make('icon')->directory('icons')->image(),
                   Forms\Components\TextInput::make('order')->numeric()->default(0),",
        'table' => "Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\ImageColumn::make('icon'),
                    Tables\Columns\TextColumn::make('order')->sortable(),"
    ],
    'Program' => [
        'icon' => 'heroicon-o-rectangle-stack',
        'form' => "Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\Textarea::make('description')->required(),
                   Forms\Components\FileUpload::make('icon')->directory('programs'),
                   Forms\Components\TextInput::make('stats_text'),
                   Forms\Components\TextInput::make('action_text')->default('Pelajari Lebih Lanjut'),
                   Forms\Components\TextInput::make('action_url'),",
        'table' => "Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\TextColumn::make('stats_text'),"
    ],
    'RegionStat' => [
        'icon' => 'heroicon-o-map',
        'form' => "Forms\Components\TextInput::make('region_name')->required(),
                   Forms\Components\TextInput::make('branch_count')->numeric()->required(),
                   Forms\Components\TextInput::make('member_count_text')->required(),
                   Forms\Components\TextInput::make('status')->default('Aktif & Berkembang'),",
        'table' => "Tables\Columns\TextColumn::make('region_name')->searchable(),
                    Tables\Columns\TextColumn::make('branch_count'),
                    Tables\Columns\TextColumn::make('member_count_text'),"
    ],
    'Article' => [
        'icon' => 'heroicon-o-newspaper',
        'form' => "Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\TextInput::make('slug')->required(),
                   Forms\Components\FileUpload::make('image')->directory('articles')->image(),
                   Forms\Components\TextInput::make('badge'),
                   Forms\Components\DatePicker::make('published_date')->required(),
                   Forms\Components\Textarea::make('excerpt'),
                   Forms\Components\RichEditor::make('content'),",
        'table' => "Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\TextColumn::make('published_date')->date(),"
    ],
    'GalleryItem' => [
        'icon' => 'heroicon-o-photo',
        'form' => "Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\Textarea::make('caption'),
                   Forms\Components\FileUpload::make('image')->directory('gallery')->image()->required(),
                   Forms\Components\TextInput::make('category'),",
        'table' => "Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\ImageColumn::make('image'),
                    Tables\Columns\TextColumn::make('category'),"
    ],
    'SiteSetting' => [
        'icon' => 'heroicon-o-cog-6-tooth',
        'form' => "Forms\Components\TextInput::make('key')->required()->unique(ignoreRecord: true),
                   Forms\Components\Textarea::make('value'),
                   Forms\Components\Select::make('type')->options(['text'=>'Text', 'image'=>'Image'])->default('text'),
                   Forms\Components\TextInput::make('group')->default('general'),",
        'table' => "Tables\Columns\TextColumn::make('key')->searchable(),
                    Tables\Columns\TextColumn::make('value')->limit(50),
                    Tables\Columns\TextColumn::make('group'),"
    ]
];

foreach ($resources as $name => $config) {
    $resourceClass = "{$name}Resource";
    $dir = "$baseDir/$resourceClass";
    $pagesDir = "$dir/Pages";
    
    if (!is_dir($pagesDir)) {
        mkdir($pagesDir, 0777, true);
    }

    // Resource File
    $content = "<?php

namespace App\Filament\Resources;

use App\Filament\Resources\\{$resourceClass}\Pages;
use App\Models\\{$name};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class {$resourceClass} extends Resource
{
    protected static ?string \$model = {$name}::class;

    protected static ?string \$navigationIcon = '{$config['icon']}';
    
    protected static ?string \$navigationGroup = 'Content';

    public static function form(Form \$form): Form
    {
        return \$form
            ->schema([
                {$config['form']}
            ]);
    }

    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
                {$config['table']}
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\List{$name}s::route('/'),
            'create' => Pages\Create{$name}::route('/create'),
            'edit' => Pages\Edit{$name}::route('/{record}/edit'),
        ];
    }
}
";
    file_put_contents("$dir.php", $content);
    echo "Created $resourceClass.php\n";

    // Pages
    // List
    $listClass = "List{$name}s"; // Pluralization simple (adds s), watch out for GalleryItems -> ListGalleryItemss ?? No, usually Item -> Items.
    // If strict plural needed, I should handle it. 
    // Value -> Values. Program -> Programs. RegionStat -> RegionStats. Article -> Articles. GalleryItem -> GalleryItems. SiteSetting -> SiteSettings.
    // My simple appending 's' works for all these.
    
    $listContent = "<?php

namespace App\Filament\Resources\\{$resourceClass}\Pages;

use App\Filament\Resources\\{$resourceClass};
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class {$listClass} extends ListRecords
{
    protected static string \$resource = {$resourceClass}::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
";
    file_put_contents("$pagesDir/$listClass.php", $listContent);

    // Create
    $createClass = "Create{$name}";
    $createContent = "<?php

namespace App\Filament\Resources\\{$resourceClass}\Pages;

use App\Filament\Resources\\{$resourceClass};
use Filament\Resources\Pages\CreateRecord;

class {$createClass} extends CreateRecord
{
    protected static string \$resource = {$resourceClass}::class;
}
";
    file_put_contents("$pagesDir/$createClass.php", $createContent);

    // Edit
    $editClass = "Edit{$name}";
    $editContent = "<?php

namespace App\Filament\Resources\\{$resourceClass}\Pages;

use App\Filament\Resources\\{$resourceClass};
use Filament\Resources\Pages\EditRecord;

class {$editClass} extends EditRecord
{
    protected static string \$resource = {$resourceClass}::class;
}
";
    file_put_contents("$pagesDir/$editClass.php", $editContent);
}

echo "All resources generated.";
?>
