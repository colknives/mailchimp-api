<?php

namespace App\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Http\Services\MailChimpServices;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListsController extends Controller
{
    
	protected $mailChimp;

    public function __construct(
        MailChimpServices $mailChimp){

        $this->mailChimp   = $mailChimp;

    }

    public function get(){

    	$response = $this->mailChimp->getList();
    	return response()->json($response, Response::HTTP_OK);

    }

    public function create(Request $request){

    	$input = $request->all();

    	//Set contact data
    	$contact = [
    		'company'  => $input['company'],
    		'address1' => $input['address1'],
    		'address2' => $input['address2'],
    		'city'     => $input['city'],
    		'state'    => $input['state'],
    		'zip'      => $input['zip'],
    		'country'  => $input['country'],
    		'phone'    => $input['phone'],
    	];

    	//Set campaign defaults data
    	$campaign_defaults = [
    		'from_name'  => $input['from_name'],
    		'from_email' => $input['from_email'],
    		'subject'    => $input['subject'],
    		'language'   => 'en'
    	];

    	//Set data for list creation
    	$data = [
    		'name' => $input['name'],
    		'contact' => $contact,
    		'permission_reminder' => $input['permission_reminder'],
    		'campaign_defaults' => $campaign_defaults,
    		'email_type_option' => false,
    		'visibility' => $input['visibility']
    	];

    	$response = $this->mailChimp->createList($data);
    	return response()->json($response, Response::HTTP_OK);

    }

    public function update(Request $request, $id){

    	$input = $request->all();

    	//Set contact data
    	$contact = [
    		'company'  => $input['company'],
    		'address1' => $input['address1'],
    		'address2' => $input['address2'],
    		'city'     => $input['city'],
    		'state'    => $input['state'],
    		'zip'      => $input['zip'],
    		'country'  => $input['country'],
    		'phone'    => $input['phone'],
    	];

    	//Set campaign defaults data
    	$campaign_defaults = [
    		'from_name'  => $input['from_name'],
    		'from_email' => $input['from_email'],
    		'subject'    => $input['subject'],
    		'language'   => 'en'
    	];

    	//Set data for list creation
    	$data = [
    		'name' => $input['name'],
    		'contact' => $contact,
    		'permission_reminder' => $input['permission_reminder'],
    		'campaign_defaults' => $campaign_defaults,
    		'email_type_option' => false,
    		'visibility' => $input['visibility']
    	];

    	$response = $this->mailChimp->updateList($id, $data);
    	return response()->json($response, Response::HTTP_OK);

    }

    public function delete(Request $request, $id){

    	$response = $this->mailChimp->deleteList($id);
    	return response()->json($response, Response::HTTP_OK);

    }


}
