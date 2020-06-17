<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mlearningkelas extends Model{
    
    protected $hidden = [
        'guru_id', 'kelas_id', 'matapelajaran_id'
    ];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d'
    ];

    public function getJurusanAttribute($value)
    {
        return strtoupper($value);
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function matapelajaran(){
        return $this->belongsTo(Matapelajaran::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function mlearningsiswa(){
        return $this->hasMany(Mlearningsiswa::class, 'kelas_mlearning_id');
    }
    
}
