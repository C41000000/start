<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Ensures the test database is wiped clean before each test runs
uses(RefreshDatabase::class);

it('logs in with correct credentials and returns the JWT', function () {
    // 1. Arrange: Create a dummy user in the database
    User::factory()->create([
        'email' => 'caioamorim732@gmail.com',
        'password' => bcrypt('superStrongPassword123'),
        'uuid' => Str::uuid(),
    ]);

    // 2. Act: Fire the POST request to your endpoint
    // (Adjust '/api/v1/...' if your prefix is different)
    $response = $this->postJson('/api/v1/auth/login', [
        'email' => 'caioamorim732@gmail.com',
        'password' => 'superStrongPassword123',
    ]);

    // 3. Assert: Verify we got a 200 OK and the token is in the response
    $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'token_type',
        ]);
});

it('blocks login with an incorrect password and returns a 422 error', function () {
    User::factory()->create([
        'email' => 'caioamorim732@gmail.com',
        'password' => bcrypt('superStrongPassword123'),
        'uuid' => Str::uuid(),
    ]);

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => 'caioamorim732@gmail.com',
        'password' => 'wrong_password_here',
    ]);

    // Since we used ValidationException in the LoginAction,
    // Laravel should return a 422 and flag the 'email' field.
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('requires email and password fields in the request', function () {
    // Fire a completely empty login request
    $response = $this->postJson('/api/v1/auth/login', []);

    // It should fail validation (422) for both fields
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});
