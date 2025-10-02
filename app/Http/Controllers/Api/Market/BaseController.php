<?php

namespace App\Http\Controllers\Api\Market;
    
use App\Http\Controllers\Controller;
use App\Services\Api\Market\Service;

class BaseController extends Controller
{
    public function __construct(protected Service $service)
    {
    }
}