<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductIn extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function suppliers(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id','id');
    }

    public function productin_details(): HasMany
    {
        return $this->hasMany(ProductInDetail::class);
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_in_details');

        
    }
 
}
