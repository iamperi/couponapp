<?php

namespace App\Mail;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponRequested extends Mailable
{
    use Queueable, SerializesModels;

    private $coupon;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon, User $user)
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.coupons.requested',[
                'coupon' => $this->coupon,
                'user' => $this->user
            ])
            ->subject(env('APP_NAME') . ' - ' . __('Your coupon'))
            ->attach($this->coupon->getPdfPath(), [
                'as' => 'tu-cupon.pdf',
                'mime' => 'application/pdf'
            ]);
    }
}
