<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_tournament_with_valid_data()
    {
        $p1 = Player::factory()->create();
        $p2 = Player::factory()->create();

        $response = $this->postJson('/api/tournaments', [
            'type'       => 'M',
            'player_ids' => [$p1->id, $p2->id],
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'type']);

        $this->assertDatabaseHas('tournaments', [
            'type' => 'M',
        ]);
    }

    /**
     * @test
     */
    public function it_fails_to_create_tournament_with_insufficient_players()
    {
        $p1 = Player::factory()->create();

        $response = $this->postJson('/api/tournaments', [
            'type'       => 'F',
            'player_ids' => [$p1->id],
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['player_ids']);
    }

    /**
     * @test
     */
    public function it_fails_to_create_tournament_with_invalid_type()
    {
        $p1 = Player::factory()->create();
        $p2 = Player::factory()->create();

        $response = $this->postJson('/api/tournaments', [
            'type'       => 'X',
            'player_ids' => [$p1->id, $p2->id],
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['type']);
    }

    /**
     * @test
     */
    public function it_runs_a_tournament_and_returns_winner()
    {
        $p1 = Player::factory()->create();
        $p2 = Player::factory()->create();
        $p3 = Player::factory()->create();
        $p4 = Player::factory()->create();

        $tournamentResponse = $this->postJson('/api/tournaments', [
            'type'       => 'M',
            'player_ids' => [$p1->id, $p2->id, $p3->id, $p4->id],
        ]);

        $tournamentId = $tournamentResponse->json('id');

        $runResponse = $this->postJson("/api/tournaments/{$tournamentId}/run");
        $runResponse->assertStatus(200)
                    ->assertJsonStructure(['tournament_id', 'winner_id']);
    }

    /**
     * @test
     */
    public function it_shows_tournament_with_players_and_winner()
    {
        $p1 = Player::factory()->create();
        $p2 = Player::factory()->create();

        $t = Tournament::create(['type' => 'F']);
        $t->players()->sync([$p1->id, $p2->id]);
        $t->winner_id = $p2->id;
        $t->save();

        $response = $this->getJson("/api/tournaments/{$t->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'type',
                     'winner_id',
                     'players' => [
                         [
                             'id',
                             'name',
                             'gender',
                             'skill',
                             'strength',
                             'speed',
                             'reaction_time',
                             'created_at',
                             'updated_at',
                         ],
                     ],
                     'winner'  => [
                         'id',
                         'name',
                         'gender',
                         'skill',
                         'strength',
                         'speed',
                         'reaction_time',
                         'created_at',
                         'updated_at',
                     ],
                 ]);
    }
}
