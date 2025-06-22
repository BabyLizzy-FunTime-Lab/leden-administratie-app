<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    /** @use HasFactory<\Database\Factories\ContributionFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'total_contribution_fee',
        'age_discount_id',
        'membership_id',
        'book_year_id',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function age_discount()
    {
        return $this->belongsTo(AgeDiscount::class);
    }

    public function book_year()
    {
        return $this->belongsTo(BookYear::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
