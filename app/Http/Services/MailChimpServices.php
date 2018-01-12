<?php 

namespace App\Http\Services;

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

	public function createList($data){

		$this->url = env('MAILCHIMP_URL','').'/lists';
		$this->method = 'post';
		$this->body = $data;

		return $this->request();

	}

	public function updateList($id, $data){

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

	public function request(){

		try{

	      $res = $this->client->{$this->method}($this->url, [
		        'headers' => [
		        	'Authorization' =>  'apikey '.env('MAILCHIMP_API_KEY')
		       	],
		       'body' => json_encode($this->body)
		    ]);

	    }
	    catch(RequestException $e){

	    	dd($e);

	    }

		

		return json_decode($res->getBody(), true);

	}

}