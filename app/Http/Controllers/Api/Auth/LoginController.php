<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\Auth\LoginRequest;

class LoginController extends BaseController
{
    public function __invoke(LoginRequest $request)
    {
        $validated = $request->validated();

        return $this->service->login($validated);
    }
}
