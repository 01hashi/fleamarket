<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'img_url',
        'user_id',
        'condition_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likeUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function soldToUsers()
    {
        return $this->belongsToMany(User::class, 'sold_items');
    }

    public function itemPayments()
    {
        return $this->belongsToMany(Payment::class, 'sold_items');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_items');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function shops() {
        return $this->belongsToMany(Shop::class,'shop_items');
    }
}