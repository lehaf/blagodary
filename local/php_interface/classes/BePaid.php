<?php

namespace WebCompany;

class BePaid
{
    private const STORE_ID = 4226; // Тестовый Shop ID
    private const SHOP_KEY = '250e70fb83bb0bb6b2db90360f24ae228b3b8ce2e42b754a346adf22fac7d22e'; // Тестовый Shop Key
    private static string $tokenizationUrl = 'https://checkout.bepaid.by/ctp/api/checkouts';
    private static string $paymentUrl = 'https://gateway.bepaid.by/transactions/payments';
    private static string $notifyUrl = '/local/web/token.php';
    private static bool $testMode = true;


    public static function makeCardTokenPayment(string $token, int $sum, int $orderId, string $userName = '', string $currency = 'BYN'): bool
    {

        $request = [
            "request" => [
                "amount" => $sum,
                "currency" => $currency,
                "description" => "Очередная оплата подписки пользователем ".$userName,
                "tracking_id" => $orderId,
                "credit_card" => [
                    "token" => $token
                ]
            ]
        ];

        if (self::$testMode) $request['request']['test'] = true;

        $response = self::sendCheckoutRequest(self::$paymentUrl, $request);

        if (!empty($response['transaction']) && !empty($response['transaction']['status']) && $response['transaction']['status'] === 'successful') {
            return true;
        } else {
            return false;
        }
    }

    public static function bindUserCard(string $userName, string $userEmail, int $sum, int $numberOrder, string $currency = 'BYN'): array
    {
        $request = [
            'checkout' => [
                'transaction_type' => 'payment',
                'settings' => [
                    'success_url' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/personal/subscription/',
                    'cancel_url' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/personal/subscription/',
                    'notification_url' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].self::$notifyUrl,
                    'language' => 'en',
                    'customer_fields' => [
                        'read_only' => ['email'],
                        'required' => ['first_name'],
                    ],
                ],
                'order' => [
                    'amount' => $sum,
                    'currency' => $currency,
                    'description' => 'Оплата подписки на сервисе ' . $_SERVER['SERVER_NAME'],
                    'tracking_id' => $numberOrder,
                    'additional_data' => [
                        'contract' => [
                            'recurring'
                        ],
                    ],
                ],
                'customer' => [
                    'email' => $userEmail,
                    'first_name' => $userName,
                ],
            ],
        ];

        if (self::$testMode) $request['checkout']['test'] = true;

        $response = self::sendCheckoutRequest(self::$tokenizationUrl, $request);

        return $response;
    }

    public static function getPaymentResult(string $paymentToken): array
    {
        $url = 'https://checkout.bepaid.by/ctp/api/checkouts/'.$paymentToken;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode(self::STORE_ID . ':' . self::SHOP_KEY),
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    private static function sendCheckoutRequest(string $url, array $data): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-Version: 2',
            'Authorization: Basic ' . base64_encode(self::STORE_ID . ':' . self::SHOP_KEY),
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        $res = json_decode($response, true);

        return $res;
    }
}