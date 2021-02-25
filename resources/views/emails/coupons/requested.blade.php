@component('mail::message')
# Hola {{ $user->name }}

Junto a este email te enviamos tu cupón descuento.

<br>

Recuerda que tienes hasta el {{ $coupon->expires_at->format('d/m/Y H:i') }} para canjearlo.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
