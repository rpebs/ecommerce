<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function product()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
