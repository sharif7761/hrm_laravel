<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWorkspace extends Model
{
    protected $fillable = [
        'user_id','workspace_id','permission','is_active'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
