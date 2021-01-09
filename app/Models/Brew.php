<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brew extends Model
{
    use HasFactory;

    public const ALLOWED_GRIND_SIZES = ['FINE', 'MEDIUM', 'COARSE'];

    protected $guarded = [];
}
