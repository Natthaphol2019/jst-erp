<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function the_application_redirects_to_login(): void
    {
        $response = $this->get('/');

        // Application redirects to login page when not authenticated
        $response->assertRedirect(route('login'));
    }
}
