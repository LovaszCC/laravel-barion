<?php

declare(strict_types=1);

namespace LovaszCC\Barion;

use Exception;
use Illuminate\Support\Facades\Http;

final class Barion
{
    private bool $liveEnv;

    private ?string $posKey;

    public function __construct()
    {
        $this->liveEnv = (bool) config('barion.live_env');
        $this->posKey = config('barion.pos_key');
    }

    public function initPayment(array $data): array
    {

        try {
            $response = Http::withHeaders($this->setHeaders())
                ->post("{$this->getBaseUrl()}/v2/Payment/Start", $data);

            $result = json_decode($response->body());
            if (! isset($result->Transactions)) {
                throw new Exception('Payment initialization failed');
            }
        } catch (Exception $e) {
            throw new Exception('Payment initialization failed: '.$e->getMessage());
        }

        return [
            'paymentId' => $result->PaymentId,
            'GatewayUrl' => $result->GatewayUrl,
        ];
    }

    public function getPaymentStatus(string $paymentId): string
    {
        try {
            $response = Http::withHeaders($this->setHeaders())
                ->get("{$this->getBaseUrl()}/v4/payment/{$paymentId}/paymentstate");
            $result = json_decode($response->body());
            if (! isset($result->Status)) {
                throw new Exception('Payment status retrieval failed');
            }

            return $result->Status;
        } catch (Exception $e) {
            throw new Exception('Payment status retrieval failed: '.$e->getMessage());
        }
    }

    private function setHeaders(): array
    {
        if (blank($this->posKey)) {
            throw new Exception('Barion POS key is not configured (BARION_POS_KEY).');
        }

        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'x-pos-key' => $this->posKey,
        ];
    }

    private function getBaseUrl(): string
    {
        return $this->liveEnv ? 'https://api.barion.com' : 'https://api.test.barion.com';
    }
}
