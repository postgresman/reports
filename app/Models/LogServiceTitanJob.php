<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Market;

class LogServiceTitanJob extends Model
{
    use SoftDeletes;

    protected $casts = [
        'tag_type_ids' => 'array',
        'chargebee' => 'array',
        'web_session_data' => 'array',
        'attributions_sent' => 'array',
        'start' => 'datetime',
        'end' => 'datetime',
        'arrival_window_start' => 'datetime',
        'arrival_window_end' => 'datetime',
    ];

    protected $fillable = [
        'market_id','service_titan_job_id','business_unit_id','job_type_id',
        'tag_type_ids','technician_id','campaign_id','start','end',
        'arrival_window_start','arrival_window_end','customer_id','location_id',
        'latitude','longitude','summary','chargebee','web_session_data',
        'attributions_sent','job_status','s2f','referral_id'
    ];

    public function market() {
        return $this->belongsTo(Market::class);
    }

    public static function getMarketJobBookingsCounts($filter)
    {

        $startDate = $filter['startDate'] ?? null;
        $endDate = $filter['endDate'] ?? null;
        $marketIds = $filter['markets'] ?? [];

        $query = self::selectRaw('markets.name as market_name, date(log_service_titan_jobs.created_at) as date, count(*) as count')
            ->join('markets', 'market_id', '=', 'markets.id');

        if (!empty($marketIds)) {
            $query->whereIn('market_id', $marketIds);
        }

        if(!empty($startDate)) {
            $query->where('log_service_titan_jobs.created_at', '>=', $startDate);
        }

        if(!empty($endDate)) {
            $query->where('log_service_titan_jobs.created_at', '<=', $endDate);
        }

        return $query->where('markets.deleted_at', '=', null)
            ->groupBy('market_name', 'date')
            ->orderBy('date')
            ->get();
    }
}