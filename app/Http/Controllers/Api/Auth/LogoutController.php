<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\Auth\LogoutRequest;

class LogoutController extends BaseController
{
    public function __invoke(LogoutRequest $request)
    {
        $validated = $request->validated();
        return $this->service->logout($validated);
    }
}
