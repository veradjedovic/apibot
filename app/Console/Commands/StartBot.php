<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\User;
use Exception;

class StartBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            
            // Choosing the mode
            $mode = $this->choice('Enter the mode?', ['rest', 'soap'], 'soap');
            // Information about chosen mode
            $this->messageAfterOperation('The chosen mode is ' . $mode);

            // Check chosen mode
            if ($mode == 'rest') {

                // Check user
                $email = $this->ask('Enter your email?');
                $user = User::where('email', '=', $email)->first();
                $this->getException($user, 'Invalid email. Please try again!');
                $pass = $this->secret('Enter your password?');
                $this->getException(\Hash::check($pass, $user->password) && $user->api_token, 'Invalid user. Please try again!');

                // Successfully logged in message
                $this->messageAfterOperation('User is successfully logged in!');

                // Call customers.index route
                $this->callTheRoute(route('customers.index'), 'Customers.index route has been dispatched successfully. List of customers with their orders: ', ['api_token' => $user->api_token], 'debug');
//                dd($user);
//                dd(\Auth::user());
                // Call orders.index route
                $this->callTheRoute(route('orders.index'), 'Orders.index route has been dispatched successfully. List of orders with their customer: ', ['api_token' => $user->api_token], 'debug');

                // Call customers.store route
                $created_customer = $this->callTheRoute(route('customers.store'),
                    'A new customer is successfully created! Response:',
                    ['api_token' => $user->api_token,
                        'first_name' => ucfirst(strtolower(\Str::random(7))),
                        'last_name' => ucfirst(strtolower(\Str::random(10))),
                        'email' => strtolower(\Str::random(7)).'@gmail.com',
                        'street' => ucfirst(strtolower(\Str::random(7))). ' ' . rand(1, 99),
                        'country' =>'Serbia'],
                    'debug',
                    'POST');

                // Call orders.store route
                $created_order = $this->callTheRoute(route('orders.store'),
                    'A new order is successfully created! Response:',
                    ['api_token' => $user->api_token,
                        'order_amount' => rand(99, 999),
                        'shipping_amount' => rand(99, 999),
                        'tax_amount' => rand(99, 999),
                        'customer_id' => $created_customer['customer']['id']],
                    'debug',
                    'POST');
                                     
                // Call customers.update route
                $this->callTheRoute(route('customers.update', $created_customer['customer']['id']),
                    'New customer is successfully updated! Response:',
                    ['api_token' => $user->api_token,
                        'first_name' => 'Test',
                        'last_name' => 'Test',
                        'email' => strtolower(\Str::random(7)).'@gmail.com',
                        'street' => 'Test 22',
                        'country' =>'Hungary'],
                    'debug',
                    'PUT');

                // Call orders.update route
                $this->callTheRoute(route('orders.update', $created_order['order']['id']),
                    'New order is successfully updated! Response:',
                    ['api_token' => $user->api_token,
                        'order_amount' => 99,
                        'shipping_amount' => 99,
                        'tax_amount' => 99,
                        'customer_id' => $created_customer['customer']['id']],
                    'debug',
                    'PUT');

                // Call customers.show route
                $this->callTheRoute(route('customers.show', $created_customer['customer']['id']),
                    'Customers.show route has been dispatched successfully. Response:',
                    ['api_token' => $user->api_token],
                    'debug',
                    'GET');

                // Call orders.show route
                $this->callTheRoute(route('orders.show', $created_order['order']['id']),
                    'Orders.show route has been dispatched successfully. Response:',
                    ['api_token' => $user->api_token],
                    'debug',
                    'GET');

                // Call orders.destroy route
                $this->callTheRoute(route('orders.destroy', $created_order['order']['id']),
                    'New order is successfully deleted! Response:',
                    ['api_token' => $user->api_token],
                    'debug',
                    'DELETE');

                // Call customers.destroy route
                $this->callTheRoute(route('customers.destroy', $created_customer['customer']['id']),
                    'New customer is successfully deleted! Response:',
                    ['api_token' => $user->api_token],
                    'debug',
                    'DELETE');

                // End operation
                $this->messageAfterOperation('Operation has been done.');
                
            } else {

                // Call soap.index route
//                $this->callTheRoute(route('soap.index'), 'Soap.index route has been dispatched successfully. Response: ', [], 'debug');
                $request = Request::create(route('soap.index'));
                $response = app()->handle($request)->header('Content-Type', 'text/hml');
                $responseBody = $response->getContent();
                           
                // Message
                $this->messageAfterOperation('Soap.index route has been dispatched successfully. Response: ', 'debug', $responseBody ? ['customers' => $responseBody] : []);

                print_r($responseBody);
            }
            
        } catch (Exception $ex) {

            $this->info($ex->getMessage());
        }
    }

    /**
     * @param $item
     * @param $message
     * @throws Exception
     */
    protected function getException($item, $message)
    {
        if (!$item) {
            Log::info($message);
            throw new Exception ($message);
        }
    }

    /**
     * @param $message
     * @param $log
     * @param $array
     */
    private function messageAfterOperation($message = '', $log = 'info', $array = [])
    {
        Log::info('-------------------------------');
        $log == 'info' ? Log::info($message) : Log::debug($message, $array);
        Log::info('-------------------------------');

        $this->info('-------------------------------');
        $this->info($message);
        $this->info('-------------------------------');
    }

    /**
     * Call the route method
     *
     * @param $route
     * @param $message
     * @param $params
     * @param $log
     * @param $method
     * @return mixed
     */
    private function callTheRoute($route, $message = '', $params = [], $log = 'info', $method = 'GET')
    {
        $request = Request::create($route, $method, $params);
        $response = app()->handle($request);
        $responseBody = json_decode($response->getContent(), true);

        // Message
        $this->messageAfterOperation($message, $log, $responseBody ? $responseBody : []);

        print_r($responseBody);
        return $responseBody;
    }
}
