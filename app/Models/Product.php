<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','category_id','name','slug','description','price','stock','metadata'];

    protected $casts = ['metadata' => 'array','price' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function tags() { return $this->belongsToMany(Tag::class)->withTimestamps(); }
}

