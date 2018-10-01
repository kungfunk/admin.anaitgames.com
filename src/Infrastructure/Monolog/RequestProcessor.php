<?php
namespace Infrastructure\Monolog;

use Psr\Http\Message\ServerRequestInterface;

class RequestProcessor
{
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function __invoke(array $record)
    {
        $uri = $this->request->getUri();

        $record['extra']['uri'] = $uri->getPath();
        $record['extra']['query'] = $uri->getQuery();
        $record['extra']['user_info'] = $uri->getUserInfo();
        $record['extra']['ip'] = $this->request->getServerParams()['REMOTE_ADDR'];
        $record['extra']['user-agent'] = $this->request->getHeaderLine('user-agent');

        return $record;
    }
}
