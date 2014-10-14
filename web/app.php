<?hh
require __DIR__ . '/../vendor/autoload.php';

$app = new Haku\Application();
$app->get('/home', () ==> ['message' => 'this page is home']);

$app->get('/hello/{name}', $name ==> ['message' => $name]);

$app->get('/test/{id}/{name}', ($id, $name) ==> {
        // do something to use $id...
        return ['name' => $name];
    })->addTokens(['id' => '\d+']);

$app->run();