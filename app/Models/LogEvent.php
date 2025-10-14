<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogEvent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'market_id','event_name_id','session_id',
    ];

    public function market() {
        return $this->belongsTo(Market::class);
    }

    public function eventName() {
        return $this->belongsTo(EventName::class);
    }

    public static function getEventOrders($filter = [], $displayOnClient = true)
    {
        $startDate = $filter['startDate'] ?? null;
        $endDate = $filter['endDate'] ?? null;
        $marketIds = $filter['markets'] ?? [];

        $query = self::selectRaw('`order` as event_order, markets.name as market_name, event_names.name as event_name, session_id, log_events.deleted_at')
            ->join('event_names', 'event_name_id', '=', 'event_names.id')
            ->join('markets', 'market_id', '=', 'markets.id')
            ->where('event_names.deleted_at', null);

        if ($displayOnClient) {
            $query->where('display_on_client', 1);
        }

        if (!empty($marketIds)) {
            $query->whereIn('market_id', $marketIds);
        }

        if (!empty($startDate)) {
            $query->where('log_events.created_at', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->where('log_events.created_at', '<=', $endDate);
        }

        return self::selectRaw('market_name, event_order, event_name, count(*) as count')
            ->fromSub($query->distinct(), 'log_events')
            ->groupBy('market_name', 'event_order', 'event_name')
            ->orderBy('market_name', 'asc')
            ->orderBy('event_order', 'asc')
            ->get();
    }
}