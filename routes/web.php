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
Route::get('/', function () {
	return view('auth.login');
})->name('home');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
// Dashboard section
Route::get('/home', [
	'uses' => 'HomeController@getDashboard',
	'as' => 'home',
	'middleware' => 'auth'
	]);
Route::get('/subscriber', [
	'uses' => 'HomeController@getSubscriber',
	'as' => 'subscriber',
	'middleware' => 'auth'
	]);	
Route::post('/subscribersave', [
	'uses' => 'HomeController@postSubscriber',
	'as' => 'subscribersave',
	'middleware' => 'auth'
	]);	
Route::get('/batch/{batch_id}', [
	'uses' => 'HomeController@getBatch',
	'as' => 'batch',
	'middleware' => 'auth'
	]);
Route::get('/deletebatch/{batch_id}', [
	'uses' => 'HomeController@deleteBatch',
	'as' => 'deletebatch',
	'middleware' => 'auth'
	]);
Route::get('/exportpdf', [
	'uses' => 'HomeController@getExportPDF',
	'as' => 'exportpdf',
	'middleware' => 'auth'
	]);
Route::post('/exportbulkpdf', [
	'uses' => 'HomeController@postExportBulkPDF',
	'as' => 'exportbulkpdf',
	'middleware' => 'auth'
	]);
Route::get('/importexcel', [
	'uses' => 'HomeController@getImportexcel',
	'as' => 'importexcel',
	'middleware' => 'auth'
	]);	
/*Route::post('/importexcel', [
	'uses' => 'HomeController@postImportexcel',
	'as' => 'importexcel',
	'middleware' => 'auth'
	]);	*/
Route::post('/importexcel', [
	'uses' => 'MyexcelController@import_salary_sheet',
	'as' => 'importexcel',
	'middleware' => 'auth'
	]);		
Route::get('/deletentry/{tblid}', [
	'uses' => 'HomeController@deletePayslip',
	'as' => 'deletentry',
	'middleware' => 'auth'
	]);		