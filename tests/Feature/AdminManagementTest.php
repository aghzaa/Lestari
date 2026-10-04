<?php

namespace Tests\Feature;

use App\Models\Motivation;
use App\Models\Story;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminSeeder::class);
    }

    /** @test */
    public function guest_is_redirected_to_login_when_accessing_admin()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function login_page_loads_successfully()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('LESTARI');
        $response->assertSee('Masuk Dashboard Fasilitator');
    }

    /** @test */
    public function admin_can_login_with_valid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'admin@lestari.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'admin@lestari.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function admin_can_view_dashboard_with_metrics_and_charts()
    {
        $admin = User::where('email', 'admin@lestari.com')->first();

        // Buat dummy data cerita
        Story::create([
            'nama' => 'Rian',
            'umur' => 18,
            'jenis_kelamin' => 'Pria',
            'pendidikan' => 'SMA',
            'kategori' => 'Diri Sendiri',
            'cerita' => 'Terkadang saya merasa takut menghadapi masa depan setelah lulus sekolah.',
            'motivation_text' => 'Pesan penguat untuk Rian.',
            'quote_text' => 'Percaya pada prosesmu.',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard & Metrik Sosialisasi');
        $response->assertSee('Total Cerita Masuk');
        $response->assertSee('Rian');
    }

    /** @test */
    public function admin_can_filter_and_search_stories()
    {
        $admin = User::where('email', 'admin@lestari.com')->first();

        Story::create([
            'nama' => 'Bintang Pratama',
            'umur' => 15,
            'jenis_kelamin' => 'Pria',
            'pendidikan' => 'SMP',
            'kategori' => 'Teman',
            'cerita' => 'Merasa dikucilkan dalam lingkaran pertemanan di kelas.',
        ]);

        Story::create([
            'nama' => 'Citra Maharani',
            'umur' => 21,
            'jenis_kelamin' => 'Wanita',
            'pendidikan' => 'MAHASISWA',
            'kategori' => 'Keluarga',
            'cerita' => 'Beban skripsi dan ekspektasi tinggi dari orang tua.',
        ]);

        // Search by name
        $response = $this->actingAs($admin)->get('/admin/stories?search=Bintang');
        $response->assertStatus(200);
        $response->assertSee('Bintang Pratama');
        $response->assertDontSee('Citra Maharani');

        // Filter by category
        $responseCat = $this->actingAs($admin)->get('/admin/stories?kategori=Keluarga');
        $responseCat->assertStatus(200);
        $responseCat->assertSee('Citra Maharani');
        $responseCat->assertDontSee('Bintang Pratama');
    }

    /** @test */
    public function admin_can_delete_a_story()
    {
        $admin = User::where('email', 'admin@lestari.com')->first();

        $story = Story::create([
            'nama' => 'Tester Delete',
            'umur' => 19,
            'jenis_kelamin' => 'Pria',
            'pendidikan' => 'SMA',
            'kategori' => 'Diri Sendiri',
            'cerita' => 'Catatan ini akan segera dihapus oleh fasilitator.',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/stories/{$story->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('stories', ['id' => $story->id]);
    }

    /** @test */
    public function admin_can_manage_motivations_crud()
    {
        $admin = User::where('email', 'admin@lestari.com')->first();

        // 1. Create Motivation
        $storeResponse = $this->actingAs($admin)->post('/admin/motivations', [
            'kategori' => 'Diri Sendiri',
            'pesan' => 'Halo {NAMA}, kamu kuat menghadapi tantangan hari ini!',
            'quote' => 'Langkah kecil tetaplah sebuah kemajuan.',
            'is_active' => '1',
        ]);
        $storeResponse->assertRedirect();

        $motivation = Motivation::where('quote', 'Langkah kecil tetaplah sebuah kemajuan.')->first();
        $this->assertNotNull($motivation);
        $this->assertTrue($motivation->is_active);

        // 2. Toggle Status
        $toggleResponse = $this->actingAs($admin)->patch("/admin/motivations/{$motivation->id}/toggle");
        $toggleResponse->assertRedirect();
        $this->assertFalse($motivation->fresh()->is_active);

        // 3. Update Motivation
        $updateResponse = $this->actingAs($admin)->put("/admin/motivations/{$motivation->id}", [
            'kategori' => 'Diri Sendiri',
            'pesan' => 'Pembaruan: Halo {NAMA}, hari esok membawa harapan baru.',
            'quote' => 'Quote diperbarui.',
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect();
        $this->assertEquals('Quote diperbarui.', $motivation->fresh()->quote);

        // 4. Delete Motivation
        $deleteResponse = $this->actingAs($admin)->delete("/admin/motivations/{$motivation->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('motivations', ['id' => $motivation->id]);
    }

    /** @test */
    public function admin_can_logout()
    {
        $admin = User::where('email', 'admin@lestari.com')->first();

        $response = $this->actingAs($admin)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
