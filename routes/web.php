<?php

use App\Models\Apartment\Apartment;
use App\Models\Host\HostBuilding;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stripe\Account;
use Stripe\BalanceTransaction;
use Stripe\Charge;
use Stripe\File;
use Stripe\PaymentIntent;
use Stripe\Payout;
use Stripe\Stripe;
use Stripe\Transfer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});