<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commision extends Model
{
    use HasFactory;
    
    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }
   
}
