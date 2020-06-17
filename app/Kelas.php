<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model{
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d'
    ];

    public function mlearningkelas(){
        return $this->hasMany(Mlearningkelas::class);
    }
}
