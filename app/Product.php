<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
