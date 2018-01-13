<?php

namespace App\Jobs;

use App\Lists;
use App\Http\Services\MailChimpServices as MailChimp;

class CreateListJob extends Job
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
        
        $list = Lists::where('listId','=',$this->id)
                    ->whereNull('id')
                    ->first();

        if(!$list){
            return true;
        }

        $data = [
            'name' => $list['name'],
            'contact' => json_decode($list['contact']),
            'permission_reminder' => $list['permission_reminder'],
            'campaign_defaults' => json_decode($list['campaign_defaults']),
            'email_type_option' => false,
            'visibility' => $list['visibility']
        ];

        $createList = ( new MailChimp )->createList($data);

        if( $createList['status'] == 200 ){

            $data = [
                'id' => $createList['data']['id']
            ];

            $updateList = Lists::where('listId','=',$this->id)
                    ->whereNull('id')->update($data);

            return ( $updateList )? true : false;

        }
        else{

            return false;

        }

    }
}