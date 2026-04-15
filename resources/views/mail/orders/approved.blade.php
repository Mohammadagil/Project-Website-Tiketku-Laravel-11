<x-mail::message>
    Hi {{ $booking->name }}, pesanan Anda dengan kode booking {{ $booking->booking_trx_id }} telah berhasil! silahkan datang kepada
    loket terdekat untuk menukarkan dengan kode asli!

<x-mail::button :url="route('front.check_booking')">
    Contact CS
</x-mail::button>

Thanks, <br>
{{ config('app.name') }}
</x-mail::message>