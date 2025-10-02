<?php 

namespace App\Services\Api\Report;

use App\Models\LogEvent;
use App\Models\LogServiceTitanJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class Service
{
    public function conversionFunnel(array $filter): JsonResponse
    {
        $hashkey = self::class . md5(json_encode($filter));

        $logs = Cache::has($hashkey) ? Cache::get($hashkey) : LogEvent::getEventOrders($filter);

        if ($logs->isEmpty()) {
            return Response::json([
                'message' => 'No data available for the selected criteria.'
            ], 404);
        };

        Cache::put($hashkey, $logs, now()->addHours(1));

        $previous = null;

        foreach ($logs as $key => $log) {
            if ($previous && $previous->market_name !== $log->market_name) {
                $previous = null;
            }

            $log->percentage = !$previous ? 100 : round($log->count / $previous->count * 100, 2);

            $previous = $log;
        }

        return Response::json($logs, 200);
    }

    public function jobBooking(array $filter): JsonResponse
    {
        $hashkey = self::class . md5(json_encode($filter));

        $data = Cache::has($hashkey) ? Cache::get($hashkey) : LogServiceTitanJob::getMarketJobBookingsCounts($filter);

        if ($data->isEmpty()) {
            return Response::json([
                'message' => 'No data available for the selected criteria.'
            ], 404);
        };

        Cache::put($hashkey, $data, now()->addHours(1));

        $labels = [];
        $markets = [];

        foreach ($data as $row) {
            $date = $row->date;
            if (!in_array($date, $labels)) {
                $labels[] = $date;
            }
            $markets[$row->market_name][$date] = $row->count;
        }

        $series = [];

        foreach ($markets as $marketName => $counts) {
            $dataPoints = [];
            foreach ($labels as $label) {
                $dataPoints[] = [$label, $counts[$label] ?? 0];
            }
            $series[] = [
                'name' => $marketName,
                'data' => $dataPoints
            ];
        }

        return Response::json($series, 200);
    }
}
