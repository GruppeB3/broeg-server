<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Resources\BrewResource;
use App\Models\Brew;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class BrewController extends Controller
{
    /**
     * Return
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return BrewResource::collection($user->brews);
    }
}
