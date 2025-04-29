<?php
namespace App\Http\Controllers;
use App\Helpers\MailerHelper;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller{

    public function index(){
        $invoice = Invoice::with('customer')->latest()->get();

        return Inertia::render('Orders/OrderList', [
            'invoices' => $invoice,
        ])->withViewData('title', 'Orders');
    }

    public function create(){//
    }

    public function store(Request $request){//
    }

    public function show(string $id){
        $invoice = Invoice::with(['customer', 'products.product'])->findOrFail($id);
        return Inertia::render('Orders/OrderDetails', [
            'invoice' => $invoice
        ])->withViewData('title','Order Details');
    }

    public function edit(string $id){//
    }

    public function update(Request $request, string $id){
        try {
            $request->validate([
                'payment_status' => 'required|in:Success,Pending,Fail,Cancel',
                'delivery_status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled'
            ]);
            
            $invoice = Invoice::findOrFail($id);
            $invoice->update($request->only(['delivery_status', 'payment_status']));

            $orderDetails = [
                'id' => $invoice->id,
                'order_number' => '#' . $invoice->id,
                'date' => $invoice->created_at->format('Y-m-d'),
                'amount' => number_format($invoice->payable, 2),
                'payment_status' => $invoice->payment_status,
                'delivery_status' => $invoice->delivery_status,
                'customer_details' => json_decode($invoice->cus_details, true),
                'shipping_details' => json_decode($invoice->ship_details, true),
                'products' => $invoice->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'title' => $product->product->title,
                        'quantity' => $product->quantity,
                        'size' => $product->size,
                        'color' => $product->color,
                        'price' => number_format($product->price, 2),
                        'total' => number_format($product->price * $product->quantity, 2),
                    ];
                }),
            ];

            MailerHelper::sendOrderStatusEmail($orderDetails, $invoice->customer->user->email);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(string $id){//
    }
}
