<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'transaction_detail';

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
