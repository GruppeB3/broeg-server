<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Resources\BrewResource;
use App\Models\Brew;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class BrewController extends Controller
{
    /**
     * Return users brews
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return BrewResource::collection($user->brews);
    }

    /**
     * Save a new brew to users collection of brews
     *
     * @param Request $request
     * @return BrewResource
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|string',
            'local_id' => ['required', Rule::unique('brews')->where(function ($query) { return $query->where('user_id', request()->user()->id); })],
            'grind_size' => ['required', Rule::in(['FINE', 'MEDIUM', 'COARSE'])],
            'brewing_temperature' => 'required|integer|gt:0',
            'ground_coffee_amount' => 'required|numeric|gt:0',
            'bloom_water_amount' => 'required|numeric|gt:0',
            'coffee_water_ratio' => 'required|numeric|gt:0',
            'bloom_time' => 'required|integer|gt:0',
            'total_brew_time' => 'required|integer|gt:0'
        ]);

        $brew = Brew::create([
            'name' => $request->name,
            'local_id' => $request->local_id,
            'user_id' => $request->user()->id,
            'grind_size' => $request->grind_size,
            'brewing_temperature' => $request->brewing_temperature,
            'ground_coffee_amount' => $request->ground_coffee_amount,
            'bloom_water_amount' => $request->bloom_water_amount,
            'coffee_water_ratio' => $request->coffee_water_ratio,
            'bloom_time' => $request->bloom_time,
            'total_brew_time' => $request->total_brew_time
        ]);

        return new BrewResource($brew);
    }

    /**
     * Update a specific brew
     *
     * @param Request $request
     * @param int $brewInt
     * @return BrewResource|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $brewInt)
    {
        $this->validateRequest();

        $brew = Brew::where([
            ['user_id', '=', $request->user()->id],
            ['local_id', '=', $brewInt]
        ])->get()->first();

        if ($request->user()->isNot($brew->user))
            return response()->json(['message' => 'User is not the owner of the brew'], 403);

        $brew->update([
            'name' => $request->name,
            'grind_size' => $request->grind_size,
            'brewing_temperature' => $request->brewing_temperature,
            'ground_coffee_amount' => $request->ground_coffee_amount,
            'bloom_water_amount' => $request->bloom_water_amount,
            'coffee_water_ratio' => $request->coffee_water_ratio,
            'bloom_time' => $request->bloom_time,
            'total_brew_time' => $request->total_brew_time
        ]);

        return new BrewResource($brew);
    }

    /**
     * Delete a specific brew
     *
     * @param Request $request
     * @param int $brewInt
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, int $brewInt)
    {
        $brew = Brew::where([
            ['user_id', '=', $request->user()->id],
            ['local_id', '=', $brewInt]
        ])->get()->first();

        if ($request->user()->isNot($brew->user))
            return response()->json(['message' => 'User is not the owner of the brew'], 403);

        if ($brew == null) {
            return response()->json(['message' => 'An error occurred while deleting brew'], 404);
        }

        $brew->delete();

        return response()->json(['message' => 'Brew deleted']);
    }

    /**
     * Validate the request against the validation rules
     *
     * @return void
     */
    private function validateRequest(): void
    {
        request()->validate([
            'name' => 'required|string',
            'grind_size' => ['required', Rule::in(['FINE', 'MEDIUM', 'COARSE'])],
            'brewing_temperature' => 'required|integer|gt:0',
            'ground_coffee_amount' => 'required|numeric|gt:0',
            'bloom_water_amount' => 'required|numeric|gt:0',
            'coffee_water_ratio' => 'required|numeric|gt:0',
            'bloom_time' => 'required|integer|gt:0',
            'total_brew_time' => 'required|integer|gt:0'
        ]);
    }
}
