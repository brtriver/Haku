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

type Method = string;

class Route
{
    private Method $method;
    private string $pattern;
    private (function(...):array<mixed>) $action;
    private Map<mixed, mixed> $params = Map{};
    private Map<string, string> $tokens = Map{};

    public function __construct(string $pattern, (function(...):array<mixed>) $action){
        $this->pattern = $pattern;
        $this->action = $action;
        $this->method = 'GET';
    }

    public function addMethod(Method $method): void {
        $this->method = $method;
    }

    public function getMethod(): Method {
        return $this->method;
    }

    public function getPattern(): string {
        return $this->pattern;
    }

    public function getAction(): (function(...):array<mixed>) {
        return $this->action;
    }

    public function setParam(Pair<mixed, mixed> $param): void {
        $this->params->add($param);
    }

    public function getParams(): Map<mixed, mixed> {
        return $this->params;
    }

    public function addToken(Pair<string, string> $token): void {
        $this->tokens->add($token);
    }

    public function getTokens(): Map<string, string> {
        return $this->tokens;
    }
}