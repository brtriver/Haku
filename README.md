Haku is a sample API micro web application framework with Hack
============================================================

Haku is a micro web application framework like Silex or Slim but converts response to JSON.
Haku is written by Hack. so easy to read.
read `web/app.php` as a sample application code.
Haku uses [`Aura.Autoload`][1] as a autoloader, if you want to use composer one, modify `Loader.php` line in app.php

Requirements
------------

Haku works with Hack (HHVM)

Usage
-----

```php
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
```

License
-------

Haku is licensed under the MIT license.

[1]: https://github.com/auraphp/Aura.Autoload
