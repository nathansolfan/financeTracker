<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_expenses_index_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('expenses.index'))
            ->assertStatus(200)
            ->assertSee('Your Expenses');
    }

    /** @test */
    public function it_displays_the_create_expense_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('expenses.create'))
            ->assertStatus(200)
            ->assertSee('Add Expense');
    }

    /** @test */
    public function it_can_store_an_expense()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('expenses.store'), [
                'amount' => 50.75,
                'category' => 'Food',
                'description' => 'Groceries',
                'date' => now()->toDateString(),
            ])
            ->assertRedirect(route('expenses.index'))
            ->assertSessionHas('success', 'Expensed added!');

        $this->assertDatabaseHas('expenses', [
            'user_id' => $user->id,
            'amount' => 50.75,
            'category' => 'Food',
            'description' => 'Groceries',
        ]);
    }

    /** @test */
    public function it_validates_expense_data_before_storing()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('expenses.store'), [])
            ->assertSessionHasErrors([
                'amount', 'category', 'date',
            ]);
    }
}
