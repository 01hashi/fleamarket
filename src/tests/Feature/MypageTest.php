<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MypageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testIndex()
    {

        $user = User::factory()->create()->first();
        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertViewIs('mypage');
        $response->assertViewHas(['user', 'shop', 'img_url', 'sellItems', 'soldItems', 'hasAnyRole']);
    }

    public function testProfile()
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHas(['user', 'profile']);
    }

    public function test_profile_update()
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        Storage::fake('s3');
        $file = UploadedFile::fake()->image('profile.jpg');

        $data = [
            'name' => 'New Name',
            'file' => $file,
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ];

        $response = $this->post('/mypage/profile/update', $data);
        $response->assertRedirect();
        $user = $user->fresh();

        $this->assertEquals('New Name', $user->name);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ]);

        $response->assertSessionHas('success', 'プロフィールを変更しました');
    }
}