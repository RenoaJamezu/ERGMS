<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaces extends Model
{
    use HasFactory;

    protected $table = 'rental_spaces';

    protected $primaryKey = 'rental_space_id';

    protected $fillable = [
        'name',
        'description',
        'location',
        'monthly_price',
        'date_created',
        'employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }
}
