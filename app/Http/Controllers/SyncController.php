<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Lists;
use App\Http\Services\MailChimpServices;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SyncController extends Controller
{

	protected $mailChimp;

	public function __construct(
        MailChimpServices $mailChimp){

        $this->mailChimp   = $mailChimp;

    }

	public function createList(){

		$list = Lists::where('listId','=',1)->get();

		if(!$list){
			return false;
		}

		if($list['id'] == null){

    		$data = [
	    		'name' => $list['name'],
	    		'contact' => json_decode($list['contact']),
	    		'permission_reminder' => $list['permission_reminder'],
	    		'campaign_defaults' => json_decode($list['campaign_defaults']),
	    		'email_type_option' => false,
	    		'visibility' => $list['visibility']
	    	];

	    	$createList = $this->mailChimp->createList($data);

	    	if( $createList['status'] == 200 ){

	    		$list = $createList['data'];

	    		$data = [
	    			'id' => $list['id']
	    		];

	    		$updateList = Lists::find(1)->update($data);

	    		return ( $updateList )? true : false;

	    	}

	    	return false;

	    	
    	}


	}

}