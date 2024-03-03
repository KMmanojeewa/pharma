<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customer::all();
    }

    public function get_customer(string $id)
    {
        if($user = Customer::find($id)) {
            return $user;
        } else {
            return response()->json([
                'message' => 'customer not found',
            ]);
        }
    }

    public function make_order(Customer $customer, Request $request)
    {
        $status = $request->input('status');
        $order = new Order([
            'customer_id' => $customer->id,
        ]);
        if ($order->save()) {
            return response()->json([
                'message' => 'Successfully created!',
                'data' => $order->id
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-delete-customer');

        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string'
        ]);

        $customer = new Customer([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        if ($customer->save()) {
            return response()->json([
                'message' => 'Successfully created customer!'
            ], 201);

        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update-customer');
        $data = $request->validate([
            'name' => 'string',
            'phone' => 'string'
        ]);

        $customer = Customer::find($id);

        if($customer) {
            $customer->update($data);
            return response()->json([
                'message' => 'successfully updated',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function soft_delete(string $id)
    {
        $this->authorize('soft-delete-customer');

        $customer = Customer::find($id);
        if($customer) {
            $customer->delete();
            return response()->json([
                'message' => 'successfully soft deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function delete(string $id)
    {
        $this->authorize('create-delete-customer');

        $customer = Customer::find($id);
        if($customer) {
            $customer->forceDelete();
            return response()->json([
                'message' => 'successfully deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function check_customer(string $id)
    {
        if(Customer::find($id)) {
            $message = 'customer available';
        } else if(Customer::withTrashed()->find($id)) {
            $message = 'customer in trash';
        } else {
            $message = 'customer in not found';
        }

        return response()->json([
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
