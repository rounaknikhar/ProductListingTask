<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    // Mass assignment.
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    // Relationships.
    // A product belongs to a category.
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
