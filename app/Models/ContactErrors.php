<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactErrors extends Model
{
    use HasFactory;
    protected $table = 'contact_errors';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date_of_birth',
        'phone',
        'address',
        'credit_card',
        'franchise',
        'email',
    ];
}
