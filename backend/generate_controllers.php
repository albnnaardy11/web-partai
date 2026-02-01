<?php
$controllers = ['Value', 'Program', 'RegionStat', 'Article', 'GalleryItem', 'SiteSetting'];
$baseDir = __DIR__ . '/app/Http/Controllers/Api';

if (!is_dir($baseDir)) mkdir($baseDir, 0777, true);

foreach($controllers as $name) {
    $content = "<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\\$name;
use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    public function index()
    {
        return response()->json({$name}::all());
    }
}
";
    file_put_contents("$baseDir/{$name}Controller.php", $content);
    echo "Created {$name}Controller.php\n";
}

// Special handling for SiteSetting (maybe map logic?)
// Override SiteSettingController to return key-value map
$settingContent = "<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        \$settings = SiteSetting::all()->mapWithKeys(function (\$item) {
            return [\$item->key => \$item->value];
        });
        return response()->json(\$settings);
    }
}
";
file_put_contents("$baseDir/SiteSettingController.php", $settingContent);
echo "Overwrote SiteSettingController.php\n";
?>
