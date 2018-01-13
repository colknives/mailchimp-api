<?php 

namespace App\Http\Services;

use Illuminate\Http\Response;
use Queue;
use App\Lists;
use App\Jobs\CreateListJob;
use App\Jobs\UpdateListJob;
use App\Jobs\DeleteListJob;


class ListServices
{

	protected $mailChimp;

	public function __construct(MailChimpServices $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

	public function getList($data = []){

		$lists = Lists::get();

		if( !$lists ){

			$response = [
				'message' => 'Unsuccessful fetch list'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			$response = [];

			foreach ($lists as $key => $list) {
				
				$response[] = [
					'name' => $list['name'],
					'contact' => json_decode($list['contact']),
					'permission_reminder' => $list['permission_reminder'],
					'campaign_defaults' => json_decode($list['campaign_defaults']),
					'email_type_option' => $list['email_type_option'],
					'visibility' => $list['visibility'],
				];

			}

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}

	public function createList($data = []){

		$create = Lists::insertGetId($data);

		if( !$create ){

			$response = [
				'message' => 'Unsuccessful create list'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			Queue::push(new CreateListJob($create));

			$response = [
				'message' => 'Successfully created list'
			];

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}

	public function updateList($id, $data = []){

		$update = Lists::find($id)->update($data);

		if( !$update ){

			$response = [
				'message' => 'Unsuccessful update list'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			Queue::push(new UpdateListJob($id));

			$response = [
				'message' => 'Successfully updated list'
			];

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}

	public function deleteList($id, $data = []){

		$list = Lists::find($id);
		$id = $list['id'];
		$delete = $list->delete();

		if( !$delete ){

			$response = [
				'message' => 'Unsuccessful delete list'
			];

			$status = Response::HTTP_BAD_REQUEST;

		}
		else{

			Queue::push(new DeleteListJob($id));

			$response = [
				'message' => 'Successfully deleted list'
			];

			$status = Response::HTTP_OK;

		}

		return response()->json($response, $status);

	}

}