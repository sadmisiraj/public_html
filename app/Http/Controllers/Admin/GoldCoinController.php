<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldCoin;
use App\Models\GoldCoinOrder;
use App\Models\Transaction;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

class GoldCoinController extends Controller
{
    use Notify, Upload;
    
    public function index()
    {
        $pageTitle = 'Gold Coin Management';
        $coins = GoldCoin::latest()->paginate(10);
        return view('admin.gold_coin.index', compact('pageTitle', 'coins'));
    }

    public function create()
    {
        $pageTitle = 'Add New Gold Coin';
        $basic = basicControl();
        return view('admin.gold_coin.create', compact('pageTitle', 'basic'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'karat' => 'required|string|max:50',
            'price_per_gram' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $coin = new GoldCoin();
        $coin->name = $request->name;
        $coin->karat = $request->karat;
        $coin->price_per_gram = $request->price_per_gram;
        $coin->description = $request->description;
        $coin->status = $request->status;

        if ($request->hasFile('image')) {
            try {
                $file = $this->fileUpload($request->image, config('filelocation.gold_coin.path'), null, null, 'webp', 80);
                $coin->image = $file['path'];
                $coin->image_driver = $file['driver'];
            } catch (\Exception $exp) {
                return back()->with('error', 'Could not upload image: ' . $exp->getMessage())->withInput();
            }
        }

        $coin->save();

        return redirect()->route('admin.goldcoin.index')->with('success', 'Gold coin created successfully.');
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Gold Coin';
        $coin = GoldCoin::findOrFail($id);
        $basic = basicControl();
        return view('admin.gold_coin.edit', compact('pageTitle', 'coin', 'basic'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'karat' => 'required|string|max:50',
            'price_per_gram' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $coin = GoldCoin::findOrFail($id);
        $coin->name = $request->name;
        $coin->karat = $request->karat;
        $coin->price_per_gram = $request->price_per_gram;
        $coin->description = $request->description;
        $coin->status = $request->status;

        if ($request->hasFile('image')) {
            try {
                $file = $this->fileUpload($request->image, config('filelocation.gold_coin.path'), null, null, 'webp', 80, $coin->image, $coin->image_driver);
                $coin->image = $file['path'];
                $coin->image_driver = $file['driver'];
            } catch (\Exception $exp) {
                return back()->with('error', 'Could not upload image: ' . $exp->getMessage())->withInput();
            }
        }

        $coin->save();

        return redirect()->route('admin.goldcoin.index')->with('success', 'Gold coin updated successfully.');
    }

    public function destroy($id)
    {
        $coin = GoldCoin::findOrFail($id);
        
        // Check if there are any associated orders
        if ($coin->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete this coin as it has associated orders.');
        }
        
        // Remove image if exists
        if ($coin->image) {
            $this->fileDelete($coin->image_driver, $coin->image);
        }
        
        $coin->delete();
        
        return redirect()->route('admin.goldcoin.index')->with('success', 'Gold coin deleted successfully.');
    }
    
    // Order Management
    public function orders($status = 'all')
    {
        $pageTitle = ucfirst($status) . ' Gold Coin Orders';
        
        $orders = GoldCoinOrder::with(['user', 'goldCoin']);
        
        if ($status != 'all') {
            $orders = $orders->where('status', $status);
        }
        
        $orders = $orders->latest()->paginate(15);
        $basic = basicControl();
        
        return view('admin.gold_coin.orders', compact('pageTitle', 'orders', 'status', 'basic'));
    }
    
    public function orderDetails($id)
    {
        $pageTitle = 'Order Details';
        $order = GoldCoinOrder::with(['user', 'goldCoin'])->findOrFail($id);
        $basic = basicControl();
        
        return view('admin.gold_coin.order_details', compact('pageTitle', 'order', 'basic'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'admin_feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $order = GoldCoinOrder::findOrFail($id);
        $prevStatus = $order->status;
        
        // Handle refund if order is being cancelled or refunded
        if (($request->status == 'cancelled' || $request->status == 'refunded') && 
            ($prevStatus != 'cancelled' && $prevStatus != 'refunded')) {
            
            $user = $order->user;
            
            // Refund to the appropriate balance
            if ($order->payment_source == 'deposit') {
                $user->balance += $order->total_price;
            } elseif ($order->payment_source == 'profit') {
                $user->interest_balance += $order->total_price;
            } elseif ($order->payment_source == 'performance') {
                $user->profit_balance += $order->total_price;
            }
            
            $user->save();
            
            // Create transaction record for refund
            Transaction::create([
                'user_id' => $user->id,
                'amount' => $order->total_price,
                'charge' => 0,
                'type' => 'GOLD_COIN_REFUND',
                'remarks' => 'Gold coin order refunded. TRX: ' . $order->trx_id,
                'trx_id' => $order->trx_id
            ]);
        }
        
        $order->status = $request->status;
        $order->admin_feedback = $request->admin_feedback;
        $order->save();
        
        // Send notification to user about status change
        $this->userPushNotification(
            $order->user, 
            'GOLD_COIN_STATUS_UPDATED', 
            [
                'trx_id' => $order->trx_id,
                'status' => ucfirst($request->status)
            ],
            [
                'title' => 'Gold Coin Order Status Updated',
                'status' => $request->status
            ]
        );
        
        return redirect()->back()->with('success', 'Order status updated successfully');
    }
    
    public function orderHistory(Request $request)
    {
        $pageTitle = 'Gold Coin Order History';
        
        $orders = GoldCoinOrder::with(['user', 'goldCoin']);
        
        // Apply filters if set
        if ($request->user) {
            $orders = $orders->whereHas('user', function($q) use ($request) {
                $q->where('username', 'like', "%{$request->user}%")
                  ->orWhere('email', 'like', "%{$request->user}%");
            });
        }
        
        if ($request->status) {
            $orders = $orders->where('status', $request->status);
        }
        
        if ($request->from_date && $request->to_date) {
            $orders = $orders->whereBetween('created_at', [
                $request->from_date . ' 00:00:00', 
                $request->to_date . ' 23:59:59'
            ]);
        }
        
        if ($request->trx_id) {
            $orders = $orders->where('trx_id', 'like', "%{$request->trx_id}%");
        }
        
        $orders = $orders->latest()->paginate(15);
        $basic = basicControl();
        
        return view('admin.gold_coin.order_history', compact('pageTitle', 'orders', 'basic'));
    }
    
    public function exportOrderHistoryCSV(Request $request)
    {
        $orders = GoldCoinOrder::with(['user', 'goldCoin']);
        
        // Apply filters if set
        if ($request->user) {
            $orders = $orders->whereHas('user', function($q) use ($request) {
                $q->where('username', 'like', "%{$request->user}%")
                  ->orWhere('email', 'like', "%{$request->user}%");
            });
        }
        
        if ($request->status) {
            $orders = $orders->where('status', $request->status);
        }
        
        if ($request->from_date && $request->to_date) {
            $orders = $orders->whereBetween('created_at', [
                $request->from_date . ' 00:00:00', 
                $request->to_date . ' 23:59:59'
            ]);
        }
        
        if ($request->trx_id) {
            $orders = $orders->where('trx_id', 'like', "%{$request->trx_id}%");
        }
        
        $orders = $orders->latest()->get();
        
        $fileName = 'gold_coin_order_history_' . date('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $columns = ['TRX ID', 'User', 'Gold Coin', 'Weight (g)', 'Price Per Gram', 'Subtotal', 'GST Amount', 'Total Price', 'Payment Source', 'Status', 'Date'];
        
        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($orders as $order) {
                $row['TRX ID'] = $order->trx_id;
                $row['User'] = $order->user->username;
                $row['Gold Coin'] = $order->goldCoin->name . ' (' . $order->goldCoin->karat . ')';
                $row['Weight (g)'] = $order->weight_in_grams;
                $row['Price Per Gram'] = $order->price_per_gram;
                $row['Subtotal'] = $order->subtotal;
                $row['GST Amount'] = $order->gst_amount;
                $row['Total Price'] = $order->total_price;
                $row['Payment Source'] = ucfirst($order->payment_source);
                $row['Status'] = ucfirst($order->status);
                $row['Date'] = $order->created_at->format('d M, Y H:i:s');
                
                fputcsv($file, array($row['TRX ID'], $row['User'], $row['Gold Coin'], $row['Weight (g)'], $row['Price Per Gram'], $row['Subtotal'], $row['GST Amount'], $row['Total Price'], $row['Payment Source'], $row['Status'], $row['Date']));
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportOrderHistoryPDF(Request $request)
    {
        $orders = GoldCoinOrder::with(['user', 'goldCoin']);
        
        // Apply filters if set
        if ($request->user) {
            $orders = $orders->whereHas('user', function($q) use ($request) {
                $q->where('username', 'like', "%{$request->user}%")
                  ->orWhere('email', 'like', "%{$request->user}%");
            });
        }
        
        if ($request->status) {
            $orders = $orders->where('status', $request->status);
        }
        
        if ($request->from_date && $request->to_date) {
            $orders = $orders->whereBetween('created_at', [
                $request->from_date . ' 00:00:00', 
                $request->to_date . ' 23:59:59'
            ]);
        }
        
        if ($request->trx_id) {
            $orders = $orders->where('trx_id', 'like', "%{$request->trx_id}%");
        }
        
        $orders = $orders->latest()->get();
        $basic = basicControl();
        
        $pageTitle = 'Gold Coin Order History';
        
        $pdf = PDF::loadView('admin.gold_coin.order_history_pdf', compact('orders', 'pageTitle', 'basic'));
        
        return $pdf->download('gold_coin_order_history_' . date('Y-m-d') . '.pdf');
    }
}
