<?php

namespace App\Http\Controllers;

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

    	return $this->mailChimp->getList();

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

    	return $this->mailChimp->createList($data);

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

    	return $this->mailChimp->updateList($id, $data);

    }

    public function delete(Request $request, $id){

    	return $this->mailChimp->deleteList($id);

    }


}
