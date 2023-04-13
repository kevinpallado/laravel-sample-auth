<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// helpers
use App\Helpers\Interfaces\ResponseCodesInterface;
use App\Helpers\APIResponseHelper;

class Controller extends BaseController implements ResponseCodesInterface
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, APIResponseHelper;

    public function __construct() {
        $this->ipAddress = request()->ip();
    }
}
