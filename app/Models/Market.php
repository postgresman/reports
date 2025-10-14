<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\LogServiceTitanJob;
use App\Models\LogEvent;

class Market extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'domain',
        'path',
        'time_zone_id',
        'latest_unavailability'
    ];

    public function serviceTitanJobs() {
        return $this->hasMany(LogServiceTitanJob::class);
    }

    public function logEvents() {
        return $this->hasMany(LogEvent::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_markets');
    }
}