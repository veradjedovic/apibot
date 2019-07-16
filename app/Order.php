<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_amount', 'shipping_amount', 'tax_amount', 'customer_id',
    ];


    /**
     * Relation between orders and customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetAll()
    {
        $items = $this->with('customer')->orderBy('customer_id', 'asc')->get();

        $this->getException($items, 'Orders are not found.');

        return $items;
    }

    /**
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public function createItem($request)
    {
        $item = $this->create($request)->toArray();

        $this->getException($item, 'Error! Order is not created!');

        return $item;
    }

    /**
     * @param $id
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public function updateItem($request, $id)
    {
        $item = $this->find($id);
        $item->order_amount = $request['order_amount'];
        $item->shipping_amount = $request['shipping_amount'];
        $item->tax_amount = $request['tax_amount'];
        $item->customer_id = $request['customer_id'];
        $item->save();

        $this->getException($item, 'Error! Order is not updated!');

        return $item;
    }

    /**
     * @param $id
     * @return bool|null
     * @throws Exception
     */
    public function deleteItem($id)
    {
        $item = $this->destroy($id);

        $this->getException($item, 'Error! Order is not deleted!');

        return $item;
    }

    /**
     * @param $item
     * @param $message
     * @throws Exception
     */
    protected function getException($item, $message)
    {
        if (!$item) {
            throw new Exception ($message);
        }
    }
}
