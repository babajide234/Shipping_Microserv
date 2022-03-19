<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    protected $table =  'tokens';
    protected $primaryKey = 'id';

    protected $fillable = [
        'access_token',
        'token_type',
        'expires_in',
    ];
}
