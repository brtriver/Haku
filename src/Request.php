<?hh // partial
// http://cookbook.hacklang.org/recipes/get-and-post/
namespace Haku;

class Request
{
    <<__Memoize>>
    public function query(string $key): mixed {
        return $this->queryAll()->get($key);
    }

    <<__Memoize>>
    public function request(string $key): mixed {
        return $this->requestAll()->get($key);
    }

    <<__Memoize>>
    public function server(string $key): mixed {
        return $this->serverAll()->get($key);
    }

     public function queryAll(): Map<string, mixed> {
        return Map::fromArray($_GET);
    }

     public function requestAll(): Map<string, mixed> {
        return Map::fromArray($_POST);
    }

     public function serverAll(): Map<string, mixed> {
        return Map::fromArray($_SERVER);
    }
}