<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_player_with_valid_data()
    {
        $response = $this->postJson('/api/players', [
            'name'   => 'Roger',
            'gender' => 'M',
            'skill'  => 90,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'name', 'gender', 'skill', 'strength', 'speed', 'reaction_time',
                 ]);

        $this->assertDatabaseHas('players', [
            'name'   => 'Roger',
            'gender' => 'M',
            'skill'  => 90,
        ]);
    }

    /**
     * @test
     */
    public function it_fails_to_create_player_with_invalid_data()
    {
        $response = $this->postJson('/api/players', [
            'name'   => '',
            'gender' => 'X',
            'skill'  => 200,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'gender', 'skill']);
    }

    /**
     * @test
     */
    public function it_lists_all_players()
    {
        Player::factory()->count(3)->create();

        $response = $this->getJson('/api/players');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
