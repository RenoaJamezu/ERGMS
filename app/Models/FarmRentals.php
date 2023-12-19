<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmRentals extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'farm_rentals';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rental_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'location_block'
      'location_lot'
      'hectares'
      'rental_amount'
      'availability'
    ];
}
