<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeDiscount extends Model
{
    /** @use HasFactory<\Database\Factories\AgeDiscountFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'min_age',
        'max_age',
        'discount_percentage',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
