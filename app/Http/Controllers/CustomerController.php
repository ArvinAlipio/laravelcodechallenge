<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CustomerController extends Controller
{
    public function populateCustomers()
    {
        $client = new Client(); 
        $url = "https://randomuser.me/api/?results=100&nat=AU";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $customers = json_decode($response->getBody(), true);

        foreach($customers["results"] as $customer){
            Customer::updateOrCreate([
                'firstname' => $customer["name"]["first"],
                'lastname'  => $customer["name"]["last"],
                'email'     => $customer["email"],
                'username'  => $customer["login"]["username"],
                'password'  => $customer["login"]["md5"],
                'gender'    => $customer["gender"],
                'country'   => $customer["location"]["country"],
                'city'      => $customer["location"]["city"],
                'phone'     => $customer["phone"],
            ]);	
        }

        return "Successfully populated the database";
    }
    
    public function getAllCustomers()
    {
        $customers = Customer::select('fullname', 'email', 'country');

        return $customers;
    }

    public function getCustomerById($customerId)
    {
        return response()->json(Customer::find($customerId));
    }

    public function create(Request $request)
    {
        $customer = Customer::create($request->all());

        return response()->json($customer, 201);
    }

    public function update($id, Request $request)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return response()->json($customer, 200);
    }

}