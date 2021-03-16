<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostingFormDetails extends Model
{
    public function ledger(){
        return $this->belongsTo('App\Ledger');
    }
}
