<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['no_trx','nik', 'type1','type2','remark'];

    
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'nik','id');
    }
}
