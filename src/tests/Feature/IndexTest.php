<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas('items');

        $user = User::factory()->create()->first();
        $this->actingAs($user);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas(['items', 'likeItems']);
    }

    public function testSearch()
    {

        $searchText = 'メンズ';
        $request = new Request(['searchText' => $searchText]);

        $response = $this->call('GET', '/search', ['searchText' => $searchText]);
        $response->assertStatus(200);
        $response->assertViewIs('index_search');
        $response->assertViewHas('items');
    }
}