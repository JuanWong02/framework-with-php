<?php

namespace App\Models;

use Jc\Database\Model;

class Contact extends Model {
    protected array $fillable = [
        'name',
        'phone_number',
        'user_id',
    ];
}