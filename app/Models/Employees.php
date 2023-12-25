<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employees extends Model implements Authenticatable
{
    use AuthenticatableTrait, HasFactory, HasApiTokens, Notifiable;

    protected $table = 'employees';

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function rentalSpaces()
    {
        return $this->hasMany(RentalSpaces::class, 'employee_id');
    }
}
