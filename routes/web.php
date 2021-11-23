<?php

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

/*
|--------------------------------------------------------------------------
| Tips in route grouping
|--------------------------------------------------------------------------
| 
| namespace = Inside Controllers/{namespace}
| prefix = All Url inside group prefixes with {prefix}/{url}
| as = All Route name inside group prefixes with {as}.{name}
|
*/

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
	return view('welcome');
});

Route::get('not-permitted', function(){
	return view('errors.not-permitted');
})->name('not-permitted');

Auth::routes();

// PUBLIC ROUTES
Route::get('validate', 'ValidationController@index');

//Authenticated
Route::group([
		'middleware' => 'auth',
	], function() {

		Route::get('dashboard', 'DashboardController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-user')
			->defaults('name', 'Dashboard')
			->defaults('roles', array('Admin', 'Seller', 'Rider'))
			->name('dashboard')
			->defaults('href', 'dashboard');

		Route::get('getData', 'DashboardController@getData')->name('getData');

		// USER ROUTES
		Route::get('users', 'UsersController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-users')
			->defaults('name', 'Users Management')
			->defaults('roles', array('Admin'))
			->name('users.index')
			->defaults('href', 'users');

		Route::get('users/get/{user}', 'UsersController@get')->name('users.get');

		Route::get('users/create', 'UsersController@create')->name('users.create');
		Route::post('users/store', 'UsersController@store')->name('users.store');

		Route::get('users/edit/{user}', 'UsersController@edit')->name('users.edit');
		Route::post('users/update', 'UsersController@update')->name('users.update');

		Route::get('users/delete/{user}', 'UsersController@delete')->name('users.delete');

		// SELLER

		// Transactions ROUTES
		Route::get('transactions', 'TransactionsController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-file-archive-o')
			->defaults('name', 'Transactions')
			->defaults('roles', array('Seller', 'Admin', 'Rider'))
			->name('transactions.index')
			->defaults('href', 'transactions');

		Route::get('transactions/book-now', 'BookingController@index')->name('book-now');
		Route::get('getUserAddress', 'BookingController@getUserAddress')->name('getUserAddress');
		Route::get('cancel/{id}', 'BookingController@cancel')->name('cancel');
		Route::get('getAll', 'BookingController@getAll')->name('getAll');

		Route::post('create', 'BookingController@create')->name('transactions.store');

		Route::get('uploadLocation', 'BookingController@uploadLocation')->name('uploadLocation');
		Route::get('getDriverLocation', 'BookingController@getDriverLocation')->name('getDriverLocation');
		Route::get('getDriversLocation', 'BookingController@getDriversLocation')->name('getDriversLocation');
		Route::get('getDriversLocation2', 'BookingController@getDriversLocation2')->name('getDriversLocation2');
		Route::get('assignDriver', 'BookingController@assignDriver')->name('assignDriver');
		Route::get('checkRiderDelivery', 'BookingController@checkRiderDelivery')->name('checkRiderDelivery');
		Route::get('updateStatus', 'BookingController@updateStatus')->name('updateStatus');
		Route::post('uploadProof', 'BookingController@uploadProof')->name('uploadProof');

		// RIDER
		Route::get('income', 'TransactionsController@income')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-money')
			->defaults('name', 'Income Report')
			->defaults('roles', array('Rider'))
			->name('transactions.income')
			->defaults('href', 'income');

		Route::get('getIncome', 'TransactionsController@getIncome')->name('getIncome');

		// DATATABLE ROUTES
		Route::get('datatables/users', 'DatatablesController@users')->name('datatables.users');
		Route::get('datatables/transactions', 'DatatablesController@transactions')->name('datatables.transactions');
		Route::get('datatables/scheduled_booking', 'DatatablesController@scheduled_booking')->name('datatables.scheduled_booking');
	}
);