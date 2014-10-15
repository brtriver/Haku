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

```php
<?hh // partial
require __DIR__ . '/../vendor/autoload.php';

use Haku\Request;

$app = new Haku\Application();

// simple JSON response
$app->get('/home', () ==> ['message' => 'this page is home']);

// with uri parameter
$app->get('/hello/{name}', $name ==> ['message' => $name]);

// with condition (Aura.Router)
$app->get('/user/{id}', $name ==> ['id' => $id])->addTokens(['id' => '\d+']);

// with query parameter
$app->get('/search', (Request $r) ==> {
        if (!$r->query('q')) {
            http_response_code(400);
        }
        return ['q' => $r->query('q')];
    });

$app->run((new Request()));
```

License
-------

Haku is licensed under the MIT license.

[1]: https://github.com/auraphp/Aura.Router
