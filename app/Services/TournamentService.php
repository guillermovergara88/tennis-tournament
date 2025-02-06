<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament;

class TournamentService
{
    /**
     * @param Tournament $tournament
     * @return Tournament
     */
    public function runTournament(Tournament $tournament): Tournament
    {
        $players = $tournament->players()->get();

        $playersArray = $players->all();

        while (count($playersArray) > 1) {
            $playersArray = $this->playRound($playersArray, $tournament->type);
        }

        $winner = $playersArray[0];
        $tournament->winner_id = $winner->id;
        $tournament->save();

        return $tournament;
    }

    /**
     * @param array $players
     * @param string $tournamentType
     * @return array
     */
    private function playRound(array $players, string $tournamentType): array
    {
        $winners = [];

        for ($i = 0; $i < count($players); $i += 2) {
            $player1 = $players[$i];
            $player2 = $players[$i + 1] ?? null;

            if (!$player2) {
                $winners[] = $player1;
                break;
            }

            $winner    = $this->playMatch($player1, $player2, $tournamentType);
            $winners[] = $winner;
        }

        return $winners;
    }

    /**
     * @param Player $p1
     * @param Player $p2
     * @param string $type
     * @return Player
     */
    private function playMatch(Player $p1, Player $p2, string $type): Player
    {
        $luck1 = rand(0, 10);
        $luck2 = rand(0, 10);

        if ($type === 'M') {
            $score1 = $p1->skill + $p1->strength + $p1->speed + $luck1;
            $score2 = $p2->skill + $p2->strength + $p2->speed + $luck2;
        } else {
            $score1 = $p1->skill + $p1->reaction_time + $luck1;
            $score2 = $p2->skill + $p2->reaction_time + $luck2;
        }

        return $score1 >= $score2 ? $p1 : $p2;
    }
}
