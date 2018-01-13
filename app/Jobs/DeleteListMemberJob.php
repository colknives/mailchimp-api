<?php

namespace App\Jobs;

use App\ListMember;
use App\Lists;
use App\Http\Services\MailChimpServices as MailChimp;

class DeleteListMemberJob extends Job
{

    protected $listId;

    protected $email;


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
    public function __construct($listId, $email)
    {
        $this->listId = $listId;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $deleteMember = ( new MailChimp )->deleteMember($this->listId, $this->email);

        if( $deleteMember['status'] == 200 ){

            return true;

        }
        else{

            return false;

        }

    }
}
