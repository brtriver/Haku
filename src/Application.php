<?hh
/*
 * This file is part of the Haku package.
 *
 * (c) Masao Maeda <brt.river@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haku;

use Aura\Router\RouterFactory;
use Aura\Router\Router;
use Aura\Router\Route;

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = (new RouterFactory)->newInstance();
    }

    public function post(string $pattern, callable $action): Route {
        $route = $this->createRoute($pattern, $action);
        $route->addMethod('POST');

        return $route;
    }

    public function get(string $pattern, callable $action): Route {
        $route = $this->createRoute($pattern, $action);
        $route->addMethod('GET');

        return $route;
    }

    private function createRoute(string $pattern, callable $action): Route {
        $routes = $this->router->getRoutes();
        $route = $routes->add(null, $pattern);
        $route->addValues([
                        '_action' => $action
                              ]);
        return $route;
    }

    public function run(array $server = []) : void {
        if ($server === []) {
            $server = $_SERVER;
        }
        $path = parse_url($server['REQUEST_URI'], PHP_URL_PATH);
        $route = $this->router->match($path, $server);
        if (!$route) {
            echo "No application route was found for that URL path.";
            exit();
        }

        $action = $route->params['_action'];
        $routeParams = array_filter($route->params, $param ==> !is_object($param));
        $r = new \ReflectionFunction($action);
        $arguments = array_map($param ==> {
            if (!array_key_exists($param->name, $routeParams)) {
                throw new \RuntimeException('Cannot set parameter from routing : ' . $param->name);
            }
            return $routeParams[$param->name];
            }, $r->getParameters());
        $data = call_user_func_array($action, $arguments);
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    }
}