<?php

namespace App\Models;

use App\Mail\ShopRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function generateRegistrationToken()
    {
        $token = Str::random(64);
        $this->registration_token = $token;
        $this->save();
        return $token;
    }

    public function getRegistrationUrl()
    {
        return route('shops.register.create', ['token' => $this->registration_token]);
    }

    public function sendRegistrationEmail()
    {
        Mail::to($this->user->email)
            ->send(new ShopRegistration($this));
    }

    public function resendRegistrationEmail()
    {
        $this->generateRegistrationToken();

        $this->sendRegistrationEmail();
    }
}
