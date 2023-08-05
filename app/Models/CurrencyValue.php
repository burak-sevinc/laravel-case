<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyValue extends Model
{
    use UUID;
    use HasFactory;

    protected $keyType = 'string';

    protected $guarded = ['id'];

    protected $fillable = [
        'currency_id',
        'currency_value',
        'logged_at',
    ];

    protected $hidden = [
        // id commented because i want to see it in the response
        // 'id',
        'created_at',
        'updated_at',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
