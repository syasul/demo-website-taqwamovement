<?php

namespace App\Models;

use App\Enums\PhaseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'order',
        'status',
        'slug',
    ];

    protected $casts = [
        'status' => PhaseStatus::class,
        'order' => 'integer',
    ];

    /**
     * Get the events for the phase.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class)->orderBy('date', 'asc');
    }
}
