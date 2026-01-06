<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\AuctionItem;
use App\Models\Category;

class AuctionTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_view_auction_list()
    {
        $user = User::factory()->create();
        
        $category = Category::factory()->create();
        $auction = AuctionItem::factory()->create([
            'category_id' => $category->id,
            'status' => 'active'
        ]);

        $response = $this->actingAs($user)->get('/auctions');

        $response->assertStatus(200);
        $response->assertSee($auction->title);
    }

    public function test_guests_can_view_auction_detail()
    {
        $category = Category::factory()->create();
        $auction = AuctionItem::factory()->create([
            'category_id' => $category->id,
            'status' => 'active'
        ]);

        $response = $this->get("/auctions/{$auction->id}");

        $response->assertStatus(200);
        $response->assertSee($auction->title);
    }

    public function test_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'buyer'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_users_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }
}