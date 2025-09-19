<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['product_stock'];
    protected $primaryKey = "id";

    protected $fillabe = [ 
    'product_code',
    'product_name',
    'product_spesification',
    'product_category_id',
    'product_color_id',
    'product_allocation_id',
    'product_size',
    'product_group',
    'product_unit',
    'product_price',
    'image'];


    public function colors(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'product_color_id','id');
    }
    public function categorys(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'product_category_id','id');
    }
    public function allocations(): BelongsTo
    {
        return $this->belongsTo(ProductAllocation::class, 'product_allocation_id','id');
    }

    public function productin(): BelongsToMany
    {
        return $this->belongsToMany(ProductIn::class,'product_in_details');
    }
}
