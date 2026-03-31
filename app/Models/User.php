<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'password', 'role', 'employee_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier(): string
    {
        return $this->username;
    }

    /**
     * Get the field name for authentication.
     */
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}