<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];
    // public function products() { return $this->belongsToMany(Product::class)->withTimestamps(); }
    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'product_tags')->withTimestamps();
    }
}

