<?php

namespace App\Models\Admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory;


    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'fares.ahmed.nassar0@gmail.com');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
