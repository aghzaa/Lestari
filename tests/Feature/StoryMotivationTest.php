<?php

namespace Tests\Feature;

use App\Models\Motivation;
use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StoryMotivationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_can_create_story_record()
    {
        $story = Story::create([
            'nama' => 'Jovian Tester',
            'umur' => 17,
            'jenis_kelamin' => 'Pria',
            'pendidikan' => 'SMA',
            'kategori' => 'Diri Sendiri',
            'cerita' => 'Ujian akhir semester cukup melelahkan, tapi saya tetap berusaha.',
            'motivation_text' => 'Kamu hebat!',
            'quote_text' => 'Tetap semangat.',
        ]);

        $this->assertDatabaseHas('stories', [
            'id' => $story->id,
            'nama' => 'Jovian Tester',
            'kategori' => 'Diri Sendiri',
        ]);
    }

    /** @test */
    public function test_motivation_helper_replaces_name_placeholder()
    {
        Motivation::create([
            'kategori' => 'Teman',
            'pesan' => 'Halo {NAMA}, kamu teman yang baik!',
            'quote' => 'Sahabat sejati selalu ada.',
            'is_active' => true,
        ]);

        $result = Motivation::getRandomByCategory('Teman', 'Budi');

        $this->assertStringContainsString('Budi', $result['pesan']);
        $this->assertStringNotContainsString('{NAMA}', $result['pesan']);
        $this->assertNotEmpty($result['quote']);
    }

    /** @test */
    public function test_admin_user_can_be_found()
    {
        $this->seed(\Database\Seeders\AdminSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@lestari.com',
        ]);
    }

    /** @test */
    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('LESTARI');
        $response->assertSee('Ruang Cerita');
    }

    /** @test */
    public function test_story_submission_stores_and_returns_motivation()
    {
        $payload = [
            'nama' => 'Aulia',
            'umur' => 16,
            'jenis_kelamin' => 'Wanita',
            'pendidikan' => 'SMA',
            'kategori' => 'Keluarga',
            'cerita' => 'Terkadang saya merasa sulit mengekspresikan pendapat di rumah.',
        ];

        $response = $this->postJson('/stories', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'data' => [
                'nama' => 'Aulia',
                'kategori' => 'Keluarga',
            ],
        ]);

        $this->assertDatabaseHas('stories', [
            'nama' => 'Aulia',
            'kategori' => 'Keluarga',
        ]);
    }

    /** @test */
    public function test_story_submission_fails_when_cerita_under_10_characters()
    {
        $payload = [
            'nama' => 'Aulia',
            'umur' => 16,
            'jenis_kelamin' => 'Wanita',
            'pendidikan' => 'SMA',
            'kategori' => 'Keluarga',
            'cerita' => 'Pendek',
        ];

        $response = $this->postJson('/stories', $payload);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }
}

