<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table="brand";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_brand'
    ];}
