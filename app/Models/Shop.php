<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payed($amount)
    {
        $this->payed_amount += $amount;
        $this->due_amount -= $amount;
        if($this->due_amount < 0) { $this->due_amount = 0; }
        $this->save();
    }

    public function unpayed($amount)
    {
        $this->payed_amount -= $amount;
        $this->due_amount += $amount;
        if($this->payed_amount < 0) { $this->payed_amount = 0; }
        $this->save();
    }
}
