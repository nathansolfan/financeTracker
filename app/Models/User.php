<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // MEANS: User can have many expenses - Laravel needs to know how to find user`s expenses
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // USER can have many incomes
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function groceryLists()
    {
        return $this->hasMany(GroceryList::class);
    }
}
