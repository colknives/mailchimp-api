<?php

namespace App\Jobs;

use App\ListMember;
use App\Lists;
use App\Http\Services\MailChimpServices as MailChimp;

class UpdateListMemberJob extends Job
{

    protected $memberId;

    protected $listId;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($listId, $memberId)
    {
        $this->listId = $listId;
        $this->memberId = $memberId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $list = Lists::where('listId','=',$this->listId)
                    ->first();

        if(!$list){
            return false;
        }

        $listMember = ListMember::where('memberId','=',$this->memberId)
                    ->first();

        if(!$listMember){
            return false;
        }

        $data = [
            'email_address' => $listMember['email_address'],
            'status'        => $listMember['status']
        ];


        $updateMember = ( new MailChimp )->updateMember($list['id'], $listMember['id'], $data);

        if( $updateMember['status'] == 200 ){

            $data = [
                'id' => md5($listMember['email_address'])
            ];

            $updateList = ListMember::where('memberId','=',$this->memberId)->update($data);

            return ( $updateList )? true : false;

        }
        else{

            return false;

        }

    }
}
