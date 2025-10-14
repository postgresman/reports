<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    public function getFormattedLastUsedAttribute()
    {
        return $this->last_used_at ? $this->last_used_at->diffForHumans() : 'Never';
    }

    public function getFormattedCreatedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y, H:i') : 'N/A';
    }
}