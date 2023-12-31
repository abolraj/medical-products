<?php

use Http\Middleware\AuthMiddleware;
use Http\Middleware\GuestMiddleware;
use Model\Offer;
use Model\Order;
use Model\Product;
use Model\User;
use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

// Add your routes here

// Home - Landing
Router::get('/', function () {
    render('layout/main');
})->name('home');

// Products
Router::group(['prefix' => '/products'], function () {
    // List all
    Router::get('/', function () {
        $order = $_GET['order'] ?? null;
        $order_by = $_GET['order_by'] ?? 'updated_at';
        $order_desc = ($_GET['order_asc'] ?? true) ? 'DESC' : 'ASC';
        $products = Product::read(['*'], ['1'], ['order_by' => "$order" ?: "$order_by $order_desc",]);
        $order_bys = [
            'Newest Products' => ['created_at', 'desc'],
            'Oldest Products' => ['created_at', 'asc'],
            'Most Expensive Products' => ['price', 'desc'],
            'Chipeast Products' => ['price', 'asc'],
            'Most Number' => ['quantity', 'desc'],
            'Least Number' => ['quantity', 'asc'],
        ];
        $user_id = user('id');
        $offers = $user_id
            ? Offer::read(['*'], ["`user_id` = '$user_id'", "consumed_at IS NULL"])
            : null;
        if ($offers) {
            $offers = array_column($offers, null, 'product_id');
        }

        render('products/list', ['products' => $products, 'user' => user(), 'order_bys' => $order_bys, 'offers' => $offers]);
    })->name('products.list');
    // Pay
    Router::post('/{id}/pay', function ($product_id) {
        $product = Product::find($product_id);
        $user = User::find($_POST['user_id']);

        if ($user && $product) {
            if (Order::take_order($product, $user, $_POST['quantity']))
                return response()->json([
                    'code' => 200,
                    'message' => 'Payment successful !',
                ]);
            else
                return response()->httpCode(401)->json([
                    'code' => 401,
                    'message' => 'Taking order failed !',
                ]);
        } else {
            return response()->httpCode(401)->json([
                'code' => 401,
                'message' => 'The user or product does not exist !',
            ]);
        }
    });
});

// Orders
Router::group(['middleware' => AuthMiddleware::class, 'prefix' => '/orders'], function () {
    // List orders
    Router::get('/', function(){
        $user_id = user('id');
        $orders = User::orders($user_id);
        $orders = array_map(function($order){
            $order['product'] = Product::find($order['product_id']);
            return $order;
        }, $orders);

        render('orders/list', [
            'orders' => $orders,
            'user' => user(),
        ]);
    })->name('orders.list');
    // Cancel order
    Router::post('/{id}/cancel', function ($order_id) {
        if (Order::cancel_order($order_id)) {
            return response()->json([
                'code' => 200,
                'message' => 'Cancelled successfully !',
            ]);
        } else {
            return response()->httpCode(401)->json([
                'code' => 401,
                'message' => 'Cancelling failed !',
            ]);
        }
    })->name('orders.cancel');
    // Pay order
    Router::post('/{id}/pay', function ($order_id) {
        if (Order::pay_order($order_id)) {
            return response()->json([
                'code' => 200,
                'message' => 'Paid successfully !',
            ]);
        } else {
            return response()->httpCode(401)->json([
                'code' => 401,
                'message' => 'Paying failed !',
            ]);
        }
    })->name('orders.pay');
});

// Logout
Router::get('/logout', function () {
    User::logout();
    return response()->redirect(url('home'));
})->name('auth.logout');
// Authentication
Router::group(['middleware' => GuestMiddleware::class], function () {
    // Login
    Router::get('/login', function () {
        render('auth/login');
    })->name('auth.login');
    // Sign-in
    Router::post('/sign-in', function () {
        $user = User::login($_POST['username'], $_POST['password']);
        if ($user) {
            return response()->redirect(url('home'));
        } else {
            set_temp_data('error_message', 'The User name or password has conflicts !');
            return response()->redirect(url('auth.login'));
        }
    })->name('auth.signin');
    // Register
    Router::get('/register', function () {
        render('auth/register');
    })->name('auth.register');
    // Sign-up
    Router::post('/sign-up', function () {
        // The username already exists
        if (User::read(['id'], ["`username` = '" . $_POST['username'] . "'"])) {
            set_temp_data('error_message', 'The user already exists !');
            return response()->redirect(url('auth.register'));
        }

        if ($_POST['confirm-password'] !== $_POST['password']) {
            set_temp_data('error_message', 'Passwords are not equal !');
            return response()->redirect(url('auth.register'));
        }

        $user = User::signup([
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'phone' => $_POST['phone'],
        ]);

        set_temp_data('success_message', 'You are registered successfully !');
        return response()->redirect(url('auth.login'));
    })->name('auth.signup');
});


Router::get('/404', function () {
    render('layout/404', [], 0);
})->name('404');

Router::error(function (Request $request, \Exception $e) {
    if ($e->getCode() === 404) {
        response()->redirect(url('404'));
    }
});

// Start routing
Router::start();
