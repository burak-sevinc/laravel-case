<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use UUID;
    use HasFactory;

    protected $keyType = 'string';
    protected $fillable = [
        'long_name',
        'currency_code',
        'symbol',
        'created_by',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'created_by',
    ];
    public $timestamps = true;
}
