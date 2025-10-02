<?php 

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Services\Api\Report\Service;

class BaseController extends Controller
{
    public function __construct(protected Service $service)
    {
    }
}