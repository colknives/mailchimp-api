<?php

namespace App\Jobs;

use App\Lists;
use App\Http\Services\MailChimpServices as MailChimp;

class DeleteListJob extends Job
{

    protected $id;

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
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $deleteList = ( new MailChimp )->deleteList($this->id);

        if( $deleteList['status'] == 200 ){

            return true;

        }
        else{

            return false;

        }

    }
}
