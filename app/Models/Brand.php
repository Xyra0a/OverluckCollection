<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand';

    protected $fillable = ['name', 'slug', 'image', 'is_active'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
