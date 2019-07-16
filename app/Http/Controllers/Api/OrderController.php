<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * @var object
     */
    protected $order;


    /**
     * OrderController constructor
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->middleware('auth:api');
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $orders = $this->order->GetAll();

            return response(['data' => $orders, 'error' => false, 'message' => 'Success']);

        } catch (Exception $ex) {

            return response(['data' => null, 'error' => true, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {

            $item = $this->order->createItem($request->all());

            return response(['message' => 'The order is created.', 'order' => $item, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'order' => null, 'error' => true]);
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

            $item = $this->order->find($id);

            return response(['message' => 'Success.', 'customer' => $item, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'customer' => null, 'error' => true]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        try {

            $item = $this->order->updateItem($request->all(), $id);

            return response(['message' => 'This order is successfully updated.', 'order' => $item, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'order' => $item, 'error' => true]);
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

            $this->order->deleteItem($id);

            return response(['message' => 'This order is deleted.', 'id' => $id, 'error' => false]);

        } catch (Exception $ex) {

            return response(['message' => $ex->getMessage(), 'id' => $id, 'error' => true]);
        }
    }
}
