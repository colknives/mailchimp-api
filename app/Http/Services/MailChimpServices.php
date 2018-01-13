<?php 

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Lists;
use App\ListMember;

class MailChimpServices
{

	protected $client;

	protected $url;

	protected $method;

	protected $body;


	function __construct(){

		$this->client = new \GuzzleHttp\Client(['verify' => storage_path('certificates\cacert.pem')]);
		$this->client = new \GuzzleHttp\Client(['verify' => false]);

	}

	public function getList(){

		$this->url = env('MAILCHIMP_URL','').'/lists';
		$this->method = 'get';
		$this->body = [];

		return $this->request();

	}

	public function createList($data = []){

		$this->url = env('MAILCHIMP_URL','').'/lists';
		$this->method = 'post';
		$this->body = $data;

		return $this->request();

	}

	public function updateList($id, $data = []){

		$this->url = env('MAILCHIMP_URL','').'/lists/'.$id;
		$this->method = 'patch';
		$this->body = $data;

		return $this->request();

	}

	public function deleteList($id){

		$this->url = env('MAILCHIMP_URL','').'/lists/'.$id;
		$this->method = 'delete';
		$this->body = [];

		return $this->request();

	}

	public function getMembers($listId){

		$this->url = env('MAILCHIMP_URL','').'/lists/'.$listId.'/members';
		$this->method = 'get';
		$this->body = [];

		return $this->request();

	}

	public function addMember($listId, $data = []){

		$this->url = env('MAILCHIMP_URL','').'/lists/'.$listId.'/members';
		$this->method = 'post';
		$this->body = $data;

		return $this->request();

	}

	public function updateMember($listId, $email, $data = []){

		$this->url = env('MAILCHIMP_URL','').'/lists/'.$listId.'/members/'.$email;
		$this->method = 'patch';
		$this->body = $data;

		return $this->request();

	}

	public function deleteMember($listId, $email){

		$this->url = env('MAILCHIMP_URL','').'/lists/'.$listId.'/members/'.$email;
		$this->method = 'delete';
		$this->body = [];

		return $this->request();

	}

	public function request(){

		try{

	      $res = $this->client->{$this->method}($this->url, [
		        'headers' => [
		        	'Authorization' =>  'apikey '.env('MAILCHIMP_API_KEY')
		       	],
		       'body' => json_encode($this->body)
		    ]);

	    }
	    catch(\GuzzleHttp\Exception\ClientException $e){

	    	$exception = json_decode($e->getResponse()->getBody()->getContents());

	    	$response = [
	    		'status'  => $exception->status,
	    		'message' => $exception->title
	    	];

	    	return $response;
	    }

	    $response = [
    		'status'  => 200,
    		'data' => json_decode($res->getBody(), true)
    	];

		return $response;

	}

	public function requestApi(){

		try{

	      $res = $this->client->{$this->method}($this->url, [
		        'headers' => [
		        	'Authorization' =>  'apikey '.env('MAILCHIMP_API_KEY')
		       	],
		       'body' => json_encode($this->body)
		    ]);

	    }
	    catch(\GuzzleHttp\Exception\ClientException $e){

	    	$exception = json_decode($e->getResponse()->getBody()->getContents());

	    	$response = [
	    		'message' => $exception->title
	    	];

	    	return response()->json($response, $exception->status);
	    }

		$response = json_decode($res->getBody(), true);
		return response()->json($response, Response::HTTP_OK);

	}

}