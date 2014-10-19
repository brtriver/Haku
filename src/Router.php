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

use Haku\Route;
use Haku\RequestInterface;

class Router
{
    private Vector<Route> $routes = Vector{};

    public function getRoutes(): Vector<Route> {

        return $this->routes;
    }
    
    public function add(Route $route): void {
        $this->routes->add($route);
    }

    /**
     * Get Route if matched
     *
     * @param RequestInterface $request Request
     * @return Route|Null      Route if matched, null otherwise
     */
    public function match(RequestInterface $request): ?Route {
        $path = $this->parseUrl((string)$request->server('REQUEST_URI'));
        $method = $request->server('REQUEST_METHOD');
        $route = $this->routes->filter($route ==> {
                if ($method !== $route->getMethod()) {
                    return false;
                }
                $pattern = $route->getPattern();
                $subPatterns = $this->getUrlSubPatterns($pattern);
                return $this->isMatched($route, $path, $pattern, $subPatterns);
            });
        return $route->isEmpty()? null: $route[0];
    }

    /**
     * Get url token from pattern
     *
     * @param string                      $pattern Route pattern
     * @return Map<int, Map<int, string>> $matched names of subpattern
     */
    private function getUrlSubPatterns(string $pattern): Map<int, Map<int, string>> {
        // UNSAFE
        preg_match_all('#{([a-z][a-zA-Z0-9_]*)}#', $pattern, $matches, PREG_SET_ORDER);
        if (!is_array($matches)) {
            $matches = [];
        }
        
        return Map::fromArray($matches);
    }

    /**
     * check Route is matched or not. and set param from subparams if matched
     *
     * @param Route                      $route   Route
     * @param string                     $path    Request Uri
     * @param string                     $pattern Route pattern
     * @param Map<int, Map<int, string>> $matched names of subpattern
     * @return bool                      true if matched
     */
    private function isMatched(Route $route, string $path, string $pattern, Map<int, Map<int, string>> $subPatterns): bool{
        foreach($subPatterns as $subPattern) {
            $name = $subPattern[1];
            $p = $route->getTokens()->get($name)?: '.*?';
            $pattern = str_replace("{{$name}}", "(?P<{$name}>{$p})", $pattern);
        }
        // UNSAFE
        $isMatched = preg_match('#\A' . $pattern . '\z#', trim($path), $matches);
        if (!$isMatched) {
            return false;
        }
        // set params if matched
        foreach($subPatterns as $match) {
            $name = $match[1];
            if (isset($matches[$name])) {
                $route->setParam(Pair{$name, $matches[$name]});
            }
        }
        
        return true;
   }

    private function parseUrl(string $requestUri): string {

        // UNSAFE
        return parse_url($requestUri, PHP_URL_PATH);
    }
}