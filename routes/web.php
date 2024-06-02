<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/send-test-mail', function () { 
    $mail = Mail::send('mail',['name'=>'kriti', 'email' => "kritykarma@gmail.com", 'password' => "secret"], function($message) {
        $message->to('kritykarma@gmail.com', 'kRITI')->subject
           ('welcome');

        $message->from(env('MAIL_FROM_ADDRESS'),'Piyush');
    });

    dd($mail);

     dd("Basic Email Sent. Check your inbox.");
});