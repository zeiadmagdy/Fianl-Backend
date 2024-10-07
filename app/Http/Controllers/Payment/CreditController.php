<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CreditController extends Controller
{
    public function credit()
    {
        $token = $this->getToken();

        $order = $this->createOrder($token);

        $paymentToken = $this->getPaymentToken($order, $token);

        return \Redirect::away('https://portal.weaccept.co/api/acceptance/iframes/' . env('PAYMOB_IFRAME_ID') . '?payment_token=' . $paymentToken);
    }

    public function getToken()
    {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => env('PAYMOB_API_KEY'),
            'username' => env('PAYMOB_USERNAME'),
            'password' => env('PAYMOB_PASSWORD')
        ]);

        \Log::info('Paymob Token Response:', $response->json());

        if (isset($response->object()->token)) {
            return $response->object()->token;
        } else {
            throw new \Exception('Token not found in the response. Response: ' . json_encode($response->json()));
        }
    }

    public function createOrder($token)
    {
        $items = [
            [
                "name" => "ASC1515",
                "amount_cents" => "500000",
                "description" => "Smart Watch",
                "quantity" => "1"
            ],
            [
                "name" => "ERT6565",
                "amount_cents" => "200000",
                "description" => "Power Bank",
                "quantity" => "1"
            ]
        ];

        $data = [
            "auth_token" => $token,
            "delivery_needed" => "false",
            "amount_cents" => "100",
            "currency" => "EGP",
            "items" => $items,
        ];

        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', $data);
        return $response->object();
    }

    public function getPaymentToken($order, $token)
    {
        $billingData = [
            "apartment" => "803",
            "email" => "claudette09@exa.com",
            "floor" => "42",
            "first_name" => "Clifford",
            "street" => "Ethan Land",
            "building" => "8028",
            "phone_number" => "+86(8)9135210487",
            "shipping_method" => "PKG",
            "postal_code" => "01898",
            "city" => "Jaskolskiburgh",
            "country" => "CR",
            "last_name" => "Nicolas",
            "state" => "Utah"
        ];

        $data = [
            "auth_token" => $token,
            "amount_cents" => "100",
            "expiration" => 3600,
            "order_id" => $order->id,
            "billing_data" => $billingData,
            "currency" => "EGP",
            "integration_id" => env('PAYMOB_INTEGRATION_ID')
        ];

        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', $data);

        \Log::info('Payment Token Response:', $response->json());

        if (isset($response->object()->token)) {
            return $response->object()->token;
        } else {
            throw new \Exception('Token not found in the response. Response: ' . json_encode($response->json()));
        }
    }

    public function callback(Request $request)
    {
        $data = $request->all();
        ksort($data);
        $hmac = $data['hmac'];

        $array = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];

        $connectedString = '';
        foreach ($data as $key => $element) {
            if (in_array($key, $array)) {
                $connectedString .= $element;
            }
        }

        $secret = env('PAYMOB_HMAC_SECRET');
        $hashed = hash_hmac('sha512', $connectedString, $secret);

        if ($hashed == $hmac) {
            $orderId = $data['order'];
            $transactionId = $data['id'];

            // Redirect to a view and pass the data
            return view('payment.confirmation', [
                'orderId' => $orderId,
                'transactionId' => $transactionId,
            ]);
        }

        echo 'not secure';
        exit;
    }

    public function initiatePayment(Request $request)
    {
        // Get necessary payment details from the request (e.g., amount, order_id)
        $orderId = $request->input('order_id');
        $amount = $request->input('amount');

        // Generate a payment URL (dummy URL for example purposes)
        $paymentUrl = url('/checkout') . '?order_id=' . $orderId . '&amount=' . $amount;

        return response()->json(['payment_url' => $paymentUrl]);
    }

}
