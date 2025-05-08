<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CashfreePaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $orderId = 'ORDER_' . time();
        $orderAmount = 500.00;
        $orderCurrency = 'INR';

        // Get token from Cashfree
        $response = Http::withHeaders([
            'x-client-id'     => config('cashfree.app_id'),
            'x-client-secret' => config('cashfree.secret_key'),
            'x-api-version'   => '2022-09-01',
            'Content-Type'    => 'application/json'
        ])->post('https://sandbox.cashfree.com/pg/orders', [
            "order_id" => $orderId,
            "order_amount" => $orderAmount,
            "order_currency" => $orderCurrency,
            "customer_details" => [
                "customer_id" => "cust_001",
                "customer_email" => "test@example.com",
                "customer_phone" => "9876543210"
            ],
            "order_meta" => [
                "return_url" => config('cashfree.return_url') . '?order_id=' . $orderId
            ]
        ]);
        

        $data = $response->json();
        dd($response->json());
        if ($response->failed()) {
            return response()->json(['error' => $data], 500);
        }

        return redirect($data['payment_link']);
    }

    public function paymentCallback(Request $request)
    {
        $orderId = $request->query('order_id');

        // Get order status from Cashfree
        $response = Http::withHeaders([
            'x-client-id' => config('cashfree.app_id'),
            'x-client-secret' => config('cashfree.secret_key'),
            'x-api-version' => '2022-09-01',
            'Content-Type' => 'application/json'
        ])->get("https://sandbox.cashfree.com/pg/orders/$orderId");

        $data = $response->json();

        if ($response->successful() && isset($data['order_status']) && $data['order_status'] === 'PAID') {
            return view('cashfree.success', compact('data'));
        }

        return view('cashfree.failed', compact('data'));
    }
}
