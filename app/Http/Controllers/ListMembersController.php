<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\MailChimpServices;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListMembersController extends Controller
{
    
	protected $mailChimp;

    public function __construct(
        MailChimpServices $mailChimp){

        $this->mailChimp   = $mailChimp;

    }

    public function get(Request $request, $listId){

        return $this->mailChimp->getMembers($listId);

    }

    public function add(Request $request, $listId){

        $this->validate($request, [
            'email_address' => 'required|email',
            'status' => 'required'
        ]);

        $input = $request->all();

        //Set data for list creation
        $data = [
            'email_address' => $input['email_address'],
            'status'        => $input['status']
        ];

        return $this->mailChimp->addMember($listId, $data);

    }

    public function update(Request $request, $listId, $email){

        $this->validate($request, [
            'email_address' => 'required|email',
            'status' => 'required'
        ]);

        $input = $request->all();

        //change email to lower case and md5 hash encryption
        $email = md5(strtolower($email));

        //Set data for list creation
        $data = [
            'email_address' => $input['email_address'],
            'status'        => $input['status']
        ];

        return $this->mailChimp->updateMember($listId, $email, $data);

    }

    public function delete(Request $request, $listId, $email){

        $input = $request->all();

        //change email to lower case and md5 hash encryption
        $email = md5(strtolower($email));
        return $this->mailChimp->deleteMember($listId, $email);

    }


}
