<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organisation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function boot()
    {
        self::addGlobalScope(function (Builder $builder) {
            $builder->whereHas('contacts', function ($query) {
                $query->where('contact_id', auth()->id());
            });
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'organisation_contact');
    }
}
