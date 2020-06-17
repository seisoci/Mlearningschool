<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mlearningmateri extends Model{

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d'
    ];

    public function komentar(){
        return $this->hasMany(Mlearningkomentar::class, 'materi_mlearning_id');
    }

    public function kelas(){
        return $this->belongsTo(Mlearningkelas::class, 'kelas_mlearning_id');
    }
}
