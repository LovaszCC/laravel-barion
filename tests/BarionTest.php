<?php

use Illuminate\Support\Facades\Http;
use LovaszCC\Barion\Facades\Barion;

beforeEach(function () {
    config()->set('barion.pos_key', 'test-pos-key');
    config()->set('barion.live_env', false);
});

it('can be resolved without any barion configuration', function () {
    config()->set('barion', []);

    expect(app(\LovaszCC\Barion\Barion::class))->toBeInstanceOf(\LovaszCC\Barion\Barion::class);
});

it('starts a payment on the test environment', function () {
    Http::fake([
        'api.test.barion.com/v2/Payment/Start' => Http::response([
            'PaymentId' => 'abc123',
            'GatewayUrl' => 'https://secure.test.barion.com/Pay?Id=abc123',
            'Transactions' => [],
        ]),
    ]);

    expect(Barion::initPayment(['PaymentType' => 'Immediate']))->toBe([
        'paymentId' => 'abc123',
        'GatewayUrl' => 'https://secure.test.barion.com/Pay?Id=abc123',
    ]);

    Http::assertSent(fn ($request) => $request->hasHeader('x-pos-key', 'test-pos-key')
        && $request['PaymentType'] === 'Immediate');
});

it('uses the live api when live_env is on', function () {
    config()->set('barion.live_env', true);
    Http::fake(['api.barion.com/v4/payment/abc123/paymentstate' => Http::response(['Status' => 'Succeeded'])]);

    expect(Barion::getPaymentStatus('abc123'))->toBe('Succeeded');
});

it('reports failed requests', function () {
    Http::fake(['*' => Http::response(['Errors' => [['Title' => 'Invalid POS key']]], 400)]);

    expect(fn () => Barion::initPayment([]))->toThrow(Exception::class, 'Payment initialization failed')
        ->and(fn () => Barion::getPaymentStatus('abc123'))->toThrow(Exception::class, 'Payment status retrieval failed');
});

it('refuses to call barion without a pos key', function () {
    config()->set('barion.pos_key', null);
    Http::fake();

    expect(fn () => Barion::getPaymentStatus('abc123'))->toThrow(Exception::class, 'BARION_POS_KEY');
    Http::assertNothingSent();
});
