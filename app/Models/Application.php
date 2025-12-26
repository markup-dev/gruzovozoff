<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'transport_datetime',
        'weight',
        'dimensions',
        'from_address',
        'to_address',
        'cargo_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'transport_datetime' => 'datetime',
            'weight' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
