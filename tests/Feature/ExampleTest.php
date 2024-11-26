<?php

// it('returns a successful response', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });



test('it redirects to the dashboard', function () {
    $response = $this->get('/');

    $response->assertStatus(302); // Expect a redirect
    $response->assertRedirect('/dashboard'); // Verify the redirection is correct
});
