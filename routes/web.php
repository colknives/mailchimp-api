<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


$app->group(['prefix' => 'mailchimp', 'middleware' => 'mailchimp'], function() use ($app)
{
	//Routes for the list apis
	$app->get('list', 'ListsController@get');
	$app->post('list', 'ListsController@create');
	$app->patch('list/{id}', 'ListsController@update');
	$app->delete('list/{id}', 'ListsController@delete');

	//Routes for the members apis
	$app->get('members/{listId}', 'ListMembersController@get');
	$app->post('members/{listId}', 'ListMembersController@add');
	$app->patch('members/{listId}/{email}', 'ListMembersController@update');
	$app->delete('members/{listId}/{email}', 'ListMembersController@delete');

});
