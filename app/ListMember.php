<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'list_member';

    protected $primaryKey = 'memberId';

    protected $fillable = ['listId','id','email_address','status'];
}