<?hh // partial

$loader = include(__DIR__ . '/../src/Loader.php');

// add your Namespace to loader like below, if you need.
// $loader->addPrefix('YourVendor', __DIR__ . '/../src');

use Haku\Request;

$app = new Haku\Application();

// simple JSON response
$app->get('/home', () ==> ['message' => 'this page is home']);

// uri parameter
$app->get('/hello/{name}', $name ==> ['message' => $name]);

// with condition
$app->get('/user/{id}', $id ==> ['id' => $id])->addToken(Pair{'id',  '\d+'});

// with query parameter
$app->get('/search', (Request $r) ==> {
        if (!$r->query('q')) {
            http_response_code(400);
        }
        return ['q' => $r->query('q')];
    });

$app->run((new Request()));
