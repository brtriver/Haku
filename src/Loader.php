<?hh // partial

// use Aura.Autoload Loader
require_once __DIR__ . '/../vendor/aura/autoload/src/Loader.php';
$loader = new \Aura\Autoload\Loader();
$loader->register();
$loader->addPrefix('Haku', __DIR__);

return $loader;
