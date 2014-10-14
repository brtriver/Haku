Haku is a sample API micro web application framework with Hack
============================================================

Haku is a micro web application framework like Silex or Slim but converts response to JSON.
Haku is written by Hack. so easy to read.
read `web/app.php` as a sample application code.
Haku uses [`Aura.Router`][1] as a routing library, so you can use methods of `Aura.Router` like `addTokens`

Requirements
------------

Haku works with Hack (HHVM)

Usage
-----

```hh
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
```

License
-------

Haku is licensed under the MIT license.

[1]: https://github.com/auraphp/Aura.Router
