<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ListMemberServices;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListMembersController extends Controller
{

    protected $listMember;

    public function __construct(
        ListMemberServices $listMember){

        $this->listMember   = $listMember;

    }

    public function get(Request $request, $listId){

        return $this->listMember->getMembers($listId);

    }

    public function add(Request $request, $listId){

        $this->validate($request, [
            'email_address' => 'required|email',
            'status' => 'required'
        ]);

        $input = $request->all();

        //Set data for list creation
        $data = [
            'listId'        => $listId,
            'email_address' => $input['email_address'],
            'status'        => $input['status']
        ];

        return $this->listMember->addMember($listId, $data);

    }

    public function update(Request $request, $listId, $memberId){

        $this->validate($request, [
            'email_address' => 'required|email',
            'status' => 'required'
        ]);

        $input = $request->all();

        //Set data for list creation
        $data = [
            'listId' => $listId,
            'email_address' => $input['email_address'],
            'status'        => $input['status']
        ];

        return $this->listMember->updateMember($listId, $memberId, $data);

    }

    public function delete(Request $request, $listId, $memberId){

        $input = $request->all();

        return $this->listMember->deleteMember($listId, $memberId);

    }


}
