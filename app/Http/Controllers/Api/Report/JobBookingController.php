<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Requests\Report\JobBookingRequest;

class JobBookingController extends BaseController
{
    public function __invoke(JobBookingRequest $request)
    {
        $validated = $request->validated();
        
        return $this->service->jobBooking($validated);
    }
}
