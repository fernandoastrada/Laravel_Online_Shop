<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    //
    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
