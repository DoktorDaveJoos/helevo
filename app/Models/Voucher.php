<?php

namespace App\Models;

use App\Casts\GermanDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Voucher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'amount',
        'paid_on',
        'cashed_on',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created',
        'updated',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'paid_on' => GermanDate::class,
        'cashed_on' => GermanDate::class,
    ];

    public function amountHistory(): HasMany
    {
        return $this->hasMany(Amount::class);
    }

    public function getActualAmount()
    {
        return $this->amountHistory()->latest()->value('amount');
    }

    public function getInitialAmount()
    {
        return $this->amountHistory()->oldest()->value('amount');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
