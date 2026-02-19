<?php

declare(strict_types=1);

namespace AkselerasiPrimaDigital\FlipForBusinessPhp;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use AkselerasiPrimaDigital\FlipForBusinessPhp\AcceptPayment\AcceptPayment;

final class FlipForBusiness
{
    private Guzzle $http;

    public function __construct()
    {
        $apiKey = Config::$apiKey       ;
        $baseUrl = Config::getBaseUrl();
        $debug = Config::$debug;
        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => 'flip-for-business-php/1.0',
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':')
        ];

        $stack = HandlerStack::create();
        if ($debug) {
            $stack->push(Middleware::tap(
                function (RequestInterface $req): void {
                    error_log('[FlipFBS] ' . $req->getMethod() . ' ' . $req->getUri());
                    $b = (string) $req->getBody();
                    if ($b !== '') {
                        error_log('[FlipFBS] REQ: ' . substr($b, 0, 2000));
                    }
                },
                function (RequestInterface $req, ResponseInterface $res): void {
                    error_log('[FlipFBS] RES ' . $res->getStatusCode());
                    $b = (string) $res->getBody();
                    if ($b !== '') {
                        error_log('[FlipFBS] BODY: ' . substr($b, 0, 2000));
                    }
                }
            ));
        }

        $this->http = new Guzzle([
            'base_uri' => rtrim($baseUrl, '/') . '/',
            'headers' => $headers,
            'handler' => $stack,
        ]);
    }

    public function acceptPayment(): AcceptPayment
    {
        return new AcceptPayment($this->http);
    }
}
