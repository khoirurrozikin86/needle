<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductInDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productin(): BelongsTo
    {
        return $this->belongsTo(ProductIn::class, 'product_in_id','id');
    }

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_id','id');

        
    // }

}
