<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSiswa extends Model
{
    protected $table = 'hasil_siswas';
    protected $fillable = ['kuis_id', 'nama_siswa', 'skor'];
}
