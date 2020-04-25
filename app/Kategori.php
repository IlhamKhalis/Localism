<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table="kategori";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_kategori'
    ];}
