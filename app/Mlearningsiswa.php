<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mlearningsiswa extends Model{
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d'
    ];

    public function mlearningkelas(){
        return $this->belongsTo(Mlearningkelas::class, 'kelas_mlearning_id')->orderBy('created_at', 'desc');
    }

    public function user(){
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
