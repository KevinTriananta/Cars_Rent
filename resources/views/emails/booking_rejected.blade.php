<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Ditolak</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #dc2626;">Booking Ditolak - Cars Rent</h1>
        
        <p>Halo <strong>{{ $booking->user->name }}</strong>,</p>
        
        <p>Mohon maaf, booking Anda <strong>ditolak</strong>. Berikut detail booking yang ditolak:</p>
        
        <div style="background: #fef2f2; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626;">
            <h3 style="margin-top: 0; color: #991b1b;">Detail Booking</h3>
            <p><strong>ID Booking:</strong> #{{ $booking->id }}</p>
            <p><strong>Mobil:</strong> {{ $booking->car->name }} ({{ $booking->car->brand }})</p>
            <p><strong>Tanggal Sewa:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> <span style="background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px;">{{ ucfirst($booking->status) }}</span></p>
        </div>
        
        <p>Jika Anda ingin melakukan booking ulang, silakan pilih mobil dan tanggal lain yang tersedia.</p>
        
        <p>Jika ada pertanyaan mengenai penolakan ini, silakan hubungi kami.</p>
        
        <p>Terima kasih,<br>
        <strong>Tim Cars Rent</strong></p>
    </div>
</body>
</html>