<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use App\Models\Order;

class OrdersController extends Controller
{
        public function store(Request $request)
    {
        // Step 1: Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string|max:500',
            'numero_telephone' => 'required|string|regex:/^\+?[0-9]{8,15}$/',
            'numero_whatsapp' => 'required|string|regex:/^\+?[0-9]{8,15}$/',
            'quantite' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            // Step 2: Create the order
            $order = Order::create($validated);

            // Step 3: Return success response
            return response()->json([
                'message' => 'The order has been saved successfully.',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            // Step 4: Log error and return error response
            Log::error('Order Save Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error saving order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // validition order traking 
        public function validateOrder(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'id' => 'required|integer',
        ]);

        $order = Order::where('id', $validated['id'])
                    ->where('email', $validated['email'])
                    ->first();

        if ($order) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false], 404);
        }
    }

    // get order traking
        public function tracking($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
     

    // table to show orders by status
    public function getOrdersByStatus($status)
   {
    $orders = Order::where('status', $status)->get();
    return response()->json($orders);
   }

   //order  serch by id 
   public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }


        // update order status
        public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string', // validate allowed values if needed
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully', 'order' => $order]);
    }

    // get orders per month
        public function getOrdersPerMonth()
    {
        $ordersPerMonth = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month');

        $monthlyCounts = array_fill(1, 12, 0);

        foreach ($ordersPerMonth as $month => $count) {
            $monthlyCounts[$month] = $count;
        }

        return response()->json(array_values($monthlyCounts));
    }

    
   // delete order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    // get order id
      public function getOrderId(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string',
            'prenom' => 'required|string',
        ]);

        $order = Order::where('email', $request->email)
            ->where('nom', $request->nom)
            ->where('prenom', $request->prenom)
            ->latest()
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json($order); // Return full order data
    }



}