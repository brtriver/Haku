<?hh // partial
namespace Haku;

Interface RequestInterface
{
    public function query(string $key): mixed {}

    public function request(string $key): mixed {}

    public function server(string $key): mixed {}
    
    public function queryAll(): Map<string, mixed> {}

    public function requestAll(): Map<string, mixed> {}

    public function serverAll(): Map<string, mixed> {}
}