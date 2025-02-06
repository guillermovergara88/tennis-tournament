<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Models\Player;

class PlayerController extends Controller
{
    public function index()
    {
        return Player::all();
    }

    /**
     * @param PlayerStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PlayerStoreRequest $request)
    {
        $player = Player::create($request->validated());
        $player->refresh();
        return response()->json($player, 201);
    }
}
