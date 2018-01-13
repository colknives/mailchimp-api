<?php 

namespace App\Http\Services;

use Illuminate\Http\Response;
use Queue;
use App\ListMember;
use App\Lists;
use App\Jobs\AddListMemberJob;
use App\Jobs\UpdateListMemberJob;
use App\Jobs\DeleteListMemberJob;

class ListMemberServices
{

	public function getMembers($listId){

		$listMembers = ListMember::where('listId',$listId)->get();

		if( count($listMembers) <= 0 ){

			$response = [
				'message' => 'No members found'
			];

			return response()->json($response, Response::HTTP_NOT_FOUND);

		}

		return response()->json($listMembers, Response::HTTP_OK);

	}

	public function addMember($listId, $data = []){

		if( !Lists::find($listId) ){

			$response = [
				'message' => 'List not found'
			];

			return response()->json($response, Response::HTTP_NOT_FOUND);

		}

		$create = ListMember::insertGetId($data);

		if( !$create ){

			$response = [
				'message' => 'Unsuccessful add member'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			Queue::push(new AddListMemberJob($listId, $create));

			$response = [
				'message' => 'Successfully added member'
			];

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}

	public function updateMember($listId, $memberId, $data = []){

		$list = Lists::find($listId);

		if( !$list ){

			$response = [
				'message' => 'List not found'
			];

			return response()->json($response, Response::HTTP_NOT_FOUND);

		}

		$listMember = ListMember::find($memberId);

		if( !$listMember ){

			$response = [
				'message' => 'List Member not found'
			];

			return response()->json($response, Response::HTTP_NOT_FOUND);

		}


		$email = $listMember['id'];
		$update = $listMember->update($data);

		if( !$update ){

			$response = [
				'message' => 'Unsuccessful update member'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			Queue::push(new UpdateListMemberJob($listId, $memberId));

			$response = [
				'message' => 'Successfully updated member'
			];

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}

	public function deleteMember($listId, $memberId, $data = []){

		$list = Lists::find($listId);

		if( !$list ){

			$response = [
				'message' => 'List not found'
			];

			return response()->json($response, Response::HTTP_NOT_FOUND);

		}

		$listMember = ListMember::find($memberId);

		if( !$listMember ){

			$response = [
				'message' => 'List Member not found'
			];

			return response()->json($response, Response::HTTP_NOT_FOUND);

		}

		$email = $listMember['id'];
		$delete = $listMember->delete();

		if( !$delete ){

			$response = [
				'message' => 'Unsuccessful delete member'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			Queue::push(new DeleteListMemberJob($list['id'], $email));

			$response = [
				'message' => 'Successfully deleted member'
			];

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}



}