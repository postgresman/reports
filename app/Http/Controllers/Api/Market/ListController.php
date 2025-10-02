<?php

namespace App\Http\Controllers\Api\Market;

use App\Http\Requests\Api\Market\ListRequest;

class ListController extends BaseController
{
    public function __invoke(ListRequest $request)
    {
        //$validated = $request->validated();

        return $this->service->list([]);
    }
}
