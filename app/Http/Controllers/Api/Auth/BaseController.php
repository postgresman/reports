<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\Auth\Service;

class BaseController extends Controller
{
    public function __construct(protected Service $service)
    {
    }
}