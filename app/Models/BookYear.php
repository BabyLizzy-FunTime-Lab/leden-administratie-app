<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookYear extends Model
{
    /** @use HasFactory<\Database\Factories\BookYearFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
