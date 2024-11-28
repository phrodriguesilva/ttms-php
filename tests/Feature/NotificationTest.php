<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $adminUser;
    protected $notification;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a regular user
        $this->user = User::factory()->create([
            'role' => 'user'
        ]);

        // Create an admin user
        $this->adminUser = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create a notification for the user
        $this->notification = Notification::create([
            'user_id' => $this->user->id,
            'type' => 'test',
            'title' => 'Test Notification',
            'message' => 'This is a test notification',
            'data' => json_encode(['test_key' => 'test_value']),
        ]);
    }

    public function test_user_can_view_their_notifications()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/notifications');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'type',
                        'title',
                        'message',
                        'data',
                        'read_at',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_user_cannot_view_others_notifications()
    {
        $otherUser = User::factory()->create();
        $otherNotification = Notification::create([
            'user_id' => $otherUser->id,
            'type' => 'test',
            'title' => 'Other Test Notification',
            'message' => 'This is another test notification',
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/notifications');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonMissing(['title' => 'Other Test Notification']);
    }

    public function test_user_can_mark_notification_as_read()
    {
        $response = $this->actingAs($this->user)
            ->postJson("/api/notifications/{$this->notification->id}/mark-as-read");

        $response->assertStatus(200);
        $this->assertNotNull($this->notification->fresh()->read_at);
    }

    public function test_user_can_mark_notification_as_unread()
    {
        // First mark as read
        $this->notification->markAsRead();

        $response = $this->actingAs($this->user)
            ->postJson("/api/notifications/{$this->notification->id}/mark-as-unread");

        $response->assertStatus(200);
        $this->assertNull($this->notification->fresh()->read_at);
    }

    public function test_user_can_get_unread_count()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/notifications/unread-count');

        $response->assertStatus(200)
            ->assertJson(['count' => 1]);

        // Mark notification as read
        $this->notification->markAsRead();

        $response = $this->actingAs($this->user)
            ->getJson('/api/notifications/unread-count');

        $response->assertStatus(200)
            ->assertJson(['count' => 0]);
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        // Create additional notifications
        Notification::create([
            'user_id' => $this->user->id,
            'type' => 'test',
            'title' => 'Test Notification 2',
            'message' => 'This is another test notification',
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/notifications/mark-all-as-read');

        $response->assertStatus(200);
        
        $unreadCount = Notification::where('user_id', $this->user->id)
            ->whereNull('read_at')
            ->count();
        
        $this->assertEquals(0, $unreadCount);
    }

    public function test_user_can_delete_notification()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/notifications/{$this->notification->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('notifications', ['id' => $this->notification->id]);
    }

    public function test_user_cannot_delete_others_notification()
    {
        $otherUser = User::factory()->create();
        $otherNotification = Notification::create([
            'user_id' => $otherUser->id,
            'type' => 'test',
            'title' => 'Other Test Notification',
            'message' => 'This is another test notification',
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/notifications/{$otherNotification->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('notifications', ['id' => $otherNotification->id]);
    }

    public function test_admin_can_delete_any_notification()
    {
        $response = $this->actingAs($this->adminUser)
            ->deleteJson("/api/notifications/{$this->notification->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('notifications', ['id' => $this->notification->id]);
    }

    public function test_user_can_clear_all_notifications()
    {
        // Create additional notifications
        Notification::create([
            'user_id' => $this->user->id,
            'type' => 'test',
            'title' => 'Test Notification 2',
            'message' => 'This is another test notification',
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/notifications/clear-all');

        $response->assertStatus(200);
        
        $notificationCount = Notification::where('user_id', $this->user->id)->count();
        $this->assertEquals(0, $notificationCount);
    }
}
