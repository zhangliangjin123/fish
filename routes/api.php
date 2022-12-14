<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
	'prefix'        => '/',
    'namespace'     => 'App\Http\Controllers\Api',
    // 'middleware'    => [],
    'as'            => 'api.'
], function(){
	Route::group([
		'prefix'        => 'tiktok/',
	    'namespace'     => 'Tiktok',
	    'as'			=> 'tiktok.'
	], function(){
		Route::get('callback', 'CallbackController@index')->name('callback');
		Route::get('login', 'CallbackController@userLogin')->name('login');
		Route::post('proinfo', 'CallbackController@proinfo')->name('proinfo');
		Route::post('orderinfo', 'CallbackController@orderinfo')->name('orderinfo');
		Route::get('aggregate', 'CallbackController@aggregate')->name('aggregate');
		Route::group([
			'prefix'        => 'index/',
		    'as'			=> 'index.'
		], function(){
			Route::get('index', 'IndexController@index')->name('index');
			Route::get('ranking', 'IndexController@ranking')->name('ranking');
		});
		Route::group([
			'prefix'        => 'product/',
		    'as'			=> 'product.'
		], function(){
			Route::get('index', 'ProductController@index')->name('index');
			Route::get('options', 'ProductController@options')->name('options');
			Route::get('detail', 'ProductController@detail')->name('detail')->middleware(['getlogin']);//商品详情
			Route::get('collection', 'ProductController@collects')->name('collects')->middleware(['auths']);//收藏列表
			Route::post('collection', 'ProductController@collection')->name('collection')->middleware(['auths']);//收藏/取消收藏同一个接口
			Route::post('collect', 'ProductController@collect')->name('collect')->middleware(['auths']);//收藏
			Route::post('uncollect', 'ProductController@uncollect')->name('uncollect')->middleware(['auths']);//取消收藏
			Route::post('apply', 'ProductController@apply')->name('apply')->middleware(['auths']);//申领样品
		});

		Route::group([
			'middleware'	=> ['auths'],
			'prefix'        => 'user/',
		    'as'			=> 'user.'
		], function(){
			Route::get('address', 'AddressController@index')->name('address');
			Route::post('address', 'AddressController@add')->name('address.add');//添加地址
			Route::post('address/editer', 'AddressController@editer')->name('address.editer');
			Route::post('address/default', 'AddressController@default')->name('address.default');
			Route::post('address/remove', 'AddressController@remove')->name('address.remove');

			Route::group([
				'prefix'		=> 'darren/',
				'as'			=> 'darren.'
			], function(){
				Route::get('', 'DarrenController@index')->name('index');
				Route::post('add', 'DarrenController@add')->name('add');
				Route::post('remove', 'DarrenController@remove')->name('remove');
			});
		});

		//样品
		Route::group([
			'middleware'	=> ['auths'],
			'prefix'        => 'sample/',
		    'as'			=> 'sample.'
		], function(){
			Route::post('cancel', 'SampleController@unapply')->name('cancel');
			Route::get('lists', 'SampleController@index')->name('address');
		});
	});
});
