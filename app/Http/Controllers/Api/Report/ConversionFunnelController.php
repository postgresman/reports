<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Requests\Report\ConversionFunnelRequest;

class ConversionFunnelController extends BaseController
{
    public function __invoke(ConversionFunnelRequest $request)
    {
        $validated = $request->validated();
        
        return $this->service->conversionFunnel($validated);
    }
}
