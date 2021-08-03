<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasEvents;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasEvents;

    protected $fillable = ['code', 'name', 'description'];
    
    
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }
}
