<?php

namespace App\Mail;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.shop-registration')
            ->subject(__('Invitation for MostoleApp'))
            ->with([
                'shop' => $this->shop,
                'url' => $this->shop->getRegistrationUrl()
            ]);
    }
}
