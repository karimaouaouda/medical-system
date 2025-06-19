<?php

namespace App\Traits;

use App\Models\Geo\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Model
*/
trait HasAddress
{
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function getFullAddressAttribute(): string
    {
        return $this->address?->full_address ?? 'no address yet';
    }
}
