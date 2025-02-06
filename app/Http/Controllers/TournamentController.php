<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentStoreRequest;
use App\Models\Tournament;
use App\Services\TournamentService;

class TournamentController extends Controller
{
    /**
     * @param TournamentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TournamentStoreRequest $request)
    {
        $data = $request->validated();

        $tournament = Tournament::create([
            'type' => $data['type'],
        ]);

        $tournament->players()->sync($data['player_ids']);

        return response()->json($tournament, 201);
    }

    /**
     * @param Tournament $tournament
     * @param TournamentService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function run(Tournament $tournament, TournamentService $service)
    {
        $service->runTournament($tournament);

        return response()->json([
            'tournament_id' => $tournament->id,
            'winner_id' => $tournament->winner_id,
        ]);
    }

    public function show(Tournament $tournament)
    {
        return $tournament->load(['players', 'winner']);
    }
}
