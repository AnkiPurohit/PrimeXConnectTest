<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="PrimX API ",
     *      description="This group contains endpoints for user authentication and Product and Stock Management",
     *      @OA\Contact(
     *          email="ankitapurohit41@gmail.com"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="User Authentication and Registration"
     * )
     *
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
