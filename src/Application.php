<?hh // strict
/*
 * This file is part of the Haku package.
 *
 * (c) Masao Maeda <brt.river@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haku;

use Haku\RequestInterface;
use Haku\Router;
use Haku\Route;

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function post(string $pattern, (function(...):array<mixed>) $action): Route {
        $route = new Route($pattern, $action);
        $route->addMethod('POST');
        $this->router->add($route);

        return $route;
    }

    public function get(string $pattern, (function(...):array<mixed>) $action): Route {
        $route = new Route($pattern, $action);
        $route->addMethod('GET');
        $this->router->add($route);

        return $route;
    }

    public function put(string $pattern, (function(...):array<mixed>) $action): Route {
        $route = new Route($pattern, $action);
        $route->addMethod('PUT');
        $this->router->add($route);

        return $route;
    }

    public function delete(string $pattern, (function(...):array<mixed>) $action): Route {
        $route = new Route($pattern, $action);
        $route->addMethod('DELETE');
        $this->router->add($route);

        return $route;
    }

    public function run(RequestInterface $request) : void {
        $route = $this->router->match($request);
        if (!$route) {
            http_response_code(404);
            echo "No application route was found for that URL path.";
            exit();
        }

        $action = $route->getAction();
        $r = new \ReflectionFunction($action);
        $arguments = array_map($param ==> {
                if ($param->info['type'] === 'Haku\Request') {
                    return $request;
                }
                if (!$route->getParams()->containsKey($param->name)) {
                    throw new \RuntimeException('Cannot set parameter from routing : ' . $param->name);
                }
                return $route->getParams()->get($param->name);
            }, $r->getParameters());
        $data = call_user_func_array($action, $arguments);
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    }
}
