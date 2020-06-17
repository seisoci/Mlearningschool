<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mlearningkomentar extends Model{

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function materi(){
        return $this->belongsTo(Mlearningmateri::class, 'materi_mlearning_id');
    }
}
