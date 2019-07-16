<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Requests\CustomerRequest;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * @var object
     */
    protected $customer;

    
    /**
     * CustomerController constructor
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->middleware('auth:api');
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $customers = $this->customer->GetAll();

            return response(['data' => $customers, 'error' => false, 'message' => 'Success.']);

        } catch (Exception $ex) {

            return response(['data' => null, 'error' => true, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {

            $item = $this->customer->createItem($request->all());

            return response(['message' => 'This customer is created.', 'customer' => $item, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'customer' => null, 'error' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $item = $this->customer->find($id);

            return response(['message' => 'Success.', 'customer' => $item, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'customer' => null, 'error' => true]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        try {

            $item = $this->customer->updateItem($request->all(), $id);

            return response(['message' => 'This customer is successfully updated.', 'customer' => $item, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'customer' => $item, 'error' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $this->customer->deleteItem($id);

            return response(['message' => 'This customer is deleted.', 'id' => $id, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'id' => $id, 'error' => true]);
        }
    }
}
