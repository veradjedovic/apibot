<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Customer;

class SoapController extends Controller
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
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        try {

            $customers = $this->customer->GetAll();

            $xml = new \SimpleXMLElement("<customers></customers>");

            foreach ($customers as $k => $v) {

                $customer = $xml->addChild("customer");
                $customer->addAttribute("id", $v->id);
                $customer->addChild("firstname", $v->first_name);
                $customer->addChild("lastname", $v->last_name);
                $customer->addChild("email", $v->email);
                $customer->addChild("street", $v->street);
                $customer->addChild("country", $v->country);

                if($v->orders && $v->orders !=[]) {
                    foreach ($v->orders as $kez => $value) {

                        $order = $customer->addChild("order");
                        $order->addAttribute("id", $value->id);
                        $order->addChild("orderamount", $value->order_amount);
                        $order->addChild("shippingamount", $value->shipping_amount);
                        $order->addChild("taxamount", $value->tax_amount);

                    }
                }
            }

            $xml = $xml->asXML();

            return $xml;

        } catch (Exception $ex) {

            return $ex->getMessage();
        }
    }
}
