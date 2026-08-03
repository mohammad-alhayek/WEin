<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password_hash'];

    protected $hidden = ['password_hash'];

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password_hash);
    }
}
