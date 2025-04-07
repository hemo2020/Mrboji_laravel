<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasePricing extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getTotal()
    {
        $total = ($this->price*$this->qty);
        $discountAmount = ($total > 0 ?  (($total * $this->discount)/100) : 0);
        return number_format($total - $discountAmount, 2);
    }
}
