<?php

declare(strict_types=1);

namespace Reynaldiarya\FlipForBusinessPhp\AcceptPayment;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Reynaldiarya\FlipForBusinessPhp\Exceptions\FlipException;
use Reynaldiarya\FlipForBusinessPhp\Exceptions\HttpException;

final class AcceptPayment
{
    public function __construct(private readonly Guzzle $http)
    {
    }

    /** Create Bill */
    public function createBill(array $payload): array
    {
        $opts = ['json' => $payload];
        return $this->request('POST', 'pwf/bill', $opts);
    }

    /** Get All Bills */
    public function getAllBill(): array
    {
        return $this->request('GET', 'pwf/bill');
    }

    /** Get Bill by ID */
    public function getBill(string $billId): array
    {
        return $this->request('GET', 'pwf/' . $billId . '/bill');
    }

    /** Edit Bill */
    public function editBill(string $billId, array $payload): array
    {
        return $this->request('PUT', 'pwf/' . $billId . '/bill', ['json' => $payload]);
    }

    /** Get Payment by ID */
    public function getPayment(string $billId): array
    {
        return $this->request('GET', 'pwf/' . $billId . '/payment');
    }

    /** List Payments */
    public function getAllPayment(array $filters = []): array
    {
        return $this->request('GET', 'pwf/payment', ['query' => $filters]);
    }

    /** -------------- Request -------------- */
    private function request(string $method, string $path, array $options = []): array
    {
        try {
            $res = $this->http->request($method, ltrim($path, '/'), $options);
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), null, $e);
        }

        $status = $res->getStatusCode();
        $raw = (string) $res->getBody();
        $data = $raw !== '' ? json_decode($raw, true) : null;

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FlipException('Invalid JSON response: ' . substr($raw, 0, 500), $status);
        }
        if ($status >= 400) {
            $msg = 'HTTP ' . $status;
            $msg .= is_array($data) ? (' ' . json_encode($data, JSON_UNESCAPED_UNICODE)) : (' ' . substr($raw, 0, 500));
            $msg .= ' | PATH=' . $path;
            throw new HttpException($msg, $status);
        }
        return is_array($data) ? $data : [];
    }
}
