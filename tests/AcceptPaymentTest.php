<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Guzzle;
use Reynaldiarya\FlipForBusinessPhp\AcceptPayment\AcceptPayment;

final class AcceptPaymentTest extends TestCase
{
    private function makeService(): AcceptPayment
    {
        $apiKey = '';
        $baseUri = 'https://bigflip.id/big_sandbox_api/v2';

        if ($apiKey === '') {
            $this->markTestSkipped('Set FLIP_API_KEY (dan opsional FLIP_BASE_URI) untuk menjalankan integration test.');
        }

        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => 'flip-for-business-php-it/1.0',
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
        ];

        $http = new Guzzle([
            'base_uri' => rtrim($baseUri, '/') . '/',
            'headers' => $headers,
        ]);

        return new AcceptPayment($http);
    }

    /** @group integration */
    public function testAcceptPaymentLiveCalls(): void
    {
        $svc = $this->makeService();

        // 1) CREATE BILL
        $idemp = 'it-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4));
        $payload = [
            'title' => 'IT Test Coffee Table',
            'type' => 'SINGLE',
            'amount' => 10000,
            'redirect_url' => 'https://example.com/return',
        ];

        $bill = $svc->createBill($payload, $idemp);
        $this->assertIsArray($bill, 'Create bill response must be array');
        $this->assertArrayHasKey('link_id', $bill, 'Bill id missing');
        $billId = (string)($bill['link_id']);

        // 2) GET BILL (by id)
        $billDetail = $svc->getBill($billId);
        $this->assertIsArray($billDetail);
        $this->assertSame((string)$billId, (string)($billDetail['link_id'] ?? 0));

        // 3) EDIT BILL (opsional: set INACTIVE agar tidak aktif terus)
        try {
            $edited = $svc->editBill($billId, ['status' => 'INACTIVE']);
            $this->assertIsArray($edited);
            $this->assertArrayHasKey('status', $edited);
        } catch (Throwable $e) {
            // catat saja, tapi jangan menggagalkan integration test keseluruhan
            fwrite(STDERR, "[WARN] editBill failed: {$e->getMessage()}\n");
        }

        // 4) LIST BILLS (boleh kosong tergantung filter)
        $bills = $svc->getAllBill();
        $this->assertIsArray($bills);

        // 5) LIST PAYMENTS (range waktu bisa kosong di sandbox; tetap assert array)
        $payments = $svc->getAllPayment([
            'start_date' => date('Y-m-d', strtotime('-7 days')),
            'end_date' => date('Y-m-d'),
            'per_page' => 5,
        ]);
        $this->assertIsArray($payments);
        $this->assertArrayHasKey('data', $payments);

        // 6) GET PAYMENT by bill (kebanyakan baru ada setelah customer bayar; di sandbox mungkin kosong/404)
        try {
            $paymentByBill = $svc->getPayment($billId);
            $this->assertIsArray($paymentByBill);
        } catch (Throwable $e) {
            fwrite(STDERR, "[INFO] getPayment($billId) no data yet: {$e->getMessage()}\n");
        }
    }
}
