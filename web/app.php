<?hh // partial
require __DIR__ . '/../vendor/autoload.php';

use Haku\Request;

$app = new Haku\Application();

// simple JSON response
$app->get('/home', () ==> ['message' => 'this page is home']);

// uri parameter
$app->get('/hello/{name}', $name ==> ['message' => $name]);

// with condition
$app->get('/user/{id}', $id ==> ['id' => $id])->addTokens(['id' => '\d+']);

// with query parameter
$app->get('/search', (Request $r) ==> {
        if (!$r->query('q')) {
            http_response_code(400);
        }
        return ['q' => $r->query('q')];
    });

$app->run((new Request()));
