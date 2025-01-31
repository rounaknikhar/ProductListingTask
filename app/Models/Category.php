<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    // Mass assignment
    protected $fillable = ['name', 'is_active'];

    // Relationships
    // A category has many products.
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
