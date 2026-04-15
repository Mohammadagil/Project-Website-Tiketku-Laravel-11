<x-mail::message>
    Hi {{ $booking->name }}, terimakasih telah memesan tiket wisata di Tiketku, kami sedang memeriksa pembayaran anda saat ini. Anda dapat
    memeriksa secara berkala status pembayaran anda melalui website kami. Berikut adalah booking transaction ID anda: {{ $booking->booking_trx_id }} 

<x-mail::button :url="route('front.check_booking')">
    Check Booking
</x-mail::button>

Thanks, <br>
{{ config('app.name') }}
</x-mail::message>