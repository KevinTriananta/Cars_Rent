<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #16a34a;">Booking Disetujui - Cars Rent</h1>
        
        <p>Halo <strong>{{ $booking->user->name }}</strong>,</p>
        
        <p>Selamat! Booking Anda telah <strong>disetujui</strong>. Berikut detail booking Anda:</p>
        
        <div style="background: #f0fdf4; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #16a34a;">
            <h3 style="margin-top: 0; color: #166534;">Detail Booking</h3>
            <p><strong>ID Booking:</strong> #{{ $booking->id }}</p>
            <p><strong>Mobil:</strong> {{ $booking->car->name }} ({{ $booking->car->brand }})</p>
            <p><strong>Tanggal Sewa:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px;">{{ ucfirst($booking->status) }}</span></p>
        </div>
        
        <p>Silakan ambil mobil sesuai tanggal yang telah ditentukan. Pastikan Anda membawa KTP dan bukti booking.</p>
        
        <p>Jika ada pertanyaan, silakan hubungi kami.</p>
        
        <p>Terima kasih,<br>
        <strong>Tim Cars Rent</strong></p>
    </div>
</body>
</html>