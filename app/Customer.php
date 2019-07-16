<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'street', 'country'
    ];


    /**
     * Relation between orders and customer
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetAll()
    {
        $items = $this->with('orders')->get();

        $this->getException($items, 'Customers are not found.');

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

        $this->getException($item, 'Error, the customer is not created!');

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
        $item->first_name = $request['first_name'];
        $item->last_name = $request['last_name'];
        $item->email = $request['email'];
        $item->street = $request['street'];
        $item->country = $request['country'];
        $item->save();
        
        $this->getException($item, 'Error, the customer is not updated!');

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
             
        $this->getException($item, 'Error! Customer is not deleted!');

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
