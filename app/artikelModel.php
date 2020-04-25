<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class artikelModel extends Model
{
    protected $table="artikel";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'judul', 'id_petugas', 'id_kategori', 'artikel', 'id_brand','tanggal'
    ];
}