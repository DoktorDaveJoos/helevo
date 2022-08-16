<?php

namespace App\Models;

use App\Casts\GermanDate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'created_at',
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['actual_amount', 'initial_amount', 'last_cashed'];

    /**
     * Determine if the user is an administrator.
     *
     * @return Attribute
     */
    protected function actualAmount(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getActualAmount(),
        );
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return Attribute
     */
    protected function initialAmount(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getInitialAmount(),
        );
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return Attribute
     */
    protected function lastCashed(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->amountHistory()->count() <= 1) {
                    return '-';
                }
                return $this->getLastCashedOn();
            }
        );
    }

    public function amountHistory(): HasMany
    {
        return $this->hasMany(Amount::class);
    }

    public function getActualAmount()
    {
        return $this->amountHistory()->min('amount');
    }

    public function getInitialAmount()
    {
        return $this->amountHistory()->max('amount');
    }

    public function getLastCashedOn()
    {
        return $this->amountHistory()
            ->where('amount', '=', $this->getActualAmount())
            ->value('created_at');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
