<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'codigo';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['codigo', 'nome'];
}
