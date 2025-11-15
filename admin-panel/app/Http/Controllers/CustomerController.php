<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer; // নিশ্চিত করুন মডেলটি ইম্পোর্ট করা আছে
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        // Auth check সরিয়ে দিলাম
        $customers = Customer::with('user')->latest()->paginate(10);
        return view('pages.customers.index', compact('customers'));
    }



    public function create()
    {
        return view('pages.customers.createCustomer');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $validatedData['user_id'] = Auth::id();
        Customer::create($validatedData);

        return redirect()->route('customerIndex')->with('message', 'Customer created successfully!');
    }

    /**
     * রুট-মডেল বাইন্ডিং ব্যবহার করা হয়েছে:
     * Laravel স্বয়ংক্রিয়ভাবে URL-এর {customer} আইডি দিয়ে Customer মডেলটি খুঁজে বের করবে।
     * যদি খুঁজে না পায়, তবে এটি নিজেই 404 দেখাবে।
     */
    public function show(Customer $customer)
    {
        // $customer = Customer::findOrFail($id); // এই লাইনের আর প্রয়োজন নেই
        return view('pages.customers.viewCustomer', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        // $customer = Customer::findOrFail($id); // এই লাইনের আর প্রয়োজন নেই
        return view('pages.customers.editCustomer', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // $customer = Customer::findOrFail($id); // এই লাইনের আর প্রয়োজন নেই

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id . '|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($validatedData);

        return redirect()->route('customerIndex')->with('message', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        // $customer = Customer::findOrFail($id); // এই লাইনের আর প্রয়োজন নেই

        $customer->delete();

        return redirect()->route('customerIndex')->with('message', 'Customer deleted successfully!');
    }
}
