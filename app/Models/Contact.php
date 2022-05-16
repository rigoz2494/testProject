<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'middle_name', 'age'
    ];

    protected $casts = ['fullName'];

    protected function fullName(): Attribute
    {
        return Attribute::get(
            fn($value, $attributes) => ($attributes['last_name'] ?? '') . ' ' .
                ($attributes['first_name'] ?? '') . ' ' .
                ($attributes['middle_name'] ?? '')
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany(Organisation::class, 'organisation_contact');
    }
}
