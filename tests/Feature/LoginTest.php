<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogin()
    {
        $this->user = User::factory()->create();
        $this->get(route('car.index'))->assertRedirect(route('login'));

        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('car.index'));
    }
}
