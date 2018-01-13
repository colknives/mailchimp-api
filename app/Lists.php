<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'list';

    protected $primaryKey = 'listId';

    protected $fillable = ['id','name','contact','permission_reminder','campaign_defaults','email_type_option','visibility'];
}