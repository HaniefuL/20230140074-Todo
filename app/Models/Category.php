<?php

namespace App\Models;
Use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable = [
        'name',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
