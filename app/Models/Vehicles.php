<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // Relazione con il modello Client
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}
