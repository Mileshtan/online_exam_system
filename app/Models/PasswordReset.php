<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    //Points to table name in database
    public $table="password_resets";
    public $timestamps=false;

    // protected $primaryKey='email';
    protected $fillable=[
        'email',
        'token',
        'created_at'
    ];
}
