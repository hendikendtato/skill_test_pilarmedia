<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nip', 'birth_date', 'birth_year', 'position_id', 'department', 'phone_number', 'religion', 'id_card_photo', 'status', 'address'
    ];
}
