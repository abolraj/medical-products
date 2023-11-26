<?php

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

// Add your routes here



Router::get('/404', function(){
    render('layout/404', [], 0);
})->name('404');

Router::error(function(Request $request, \Exception $e){
    if($e->getCode() === 404){
        response()->redirect(url('404'));
    }
});

// Start routing
Router::start();