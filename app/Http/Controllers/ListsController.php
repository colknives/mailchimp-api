<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ListServices;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListsController extends Controller
{
    
    protected $list;

    public function __construct(
        ListServices $list){

        $this->list   = $list;

    }

    public function get(){

    	return $this->list->getList();

    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'company' => 'required',
            'address1' => 'required',
            'country' => 'required',
            'from_name' => 'required',
            'from_email' => 'required',
            'subject' => 'required',
            'permission_reminder' => 'required',
            'visibility' => 'required'
        ]);

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
    		'contact' => json_encode($contact),
    		'permission_reminder' => $input['permission_reminder'],
    		'campaign_defaults' => json_encode($campaign_defaults),
    		'email_type_option' => false,
    		'visibility' => $input['visibility']
    	];

    	return $this->list->createList($data);

    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'name' => 'required',
            'company' => 'required',
            'address1' => 'required',
            'country' => 'required',
            'from_name' => 'required',
            'from_email' => 'required',
            'subject' => 'required',
            'permission_reminder' => 'required',
            'visibility' => 'required'
        ]);

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
            'contact' => json_encode($contact),
            'permission_reminder' => $input['permission_reminder'],
            'campaign_defaults' => json_encode($campaign_defaults),
            'email_type_option' => false,
            'visibility' => $input['visibility']
        ];

    	return $this->list->updateList($id, $data);

    }

    public function delete(Request $request, $id){

    	return $this->list->deleteList($id);

    }


}
