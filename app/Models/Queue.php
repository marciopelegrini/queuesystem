<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\Attributes\Ticket;

class Queue extends Model
{
    use SoftDeletes;

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }

    public function tickets()
    {
        return $this->hasMany(QueueTicket::class, 'id_queue');
    }
}
