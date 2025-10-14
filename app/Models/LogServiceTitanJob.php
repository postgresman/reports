<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Market;

class LogServiceTitanJob extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'market_id',
        'start',
        'end'       
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