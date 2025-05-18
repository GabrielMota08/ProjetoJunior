<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class AccessLog extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'access_logs';

    protected $fillable = [
        'user_ip', 'user_token', 'cpf_viewed', 'viewed'
    ];
}