<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'court_id', 'content',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
    
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

}
