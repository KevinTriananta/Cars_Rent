<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Baru Dibuat</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2563eb;">Booking Baru Dibuat - Cars Rent</h1>
        
        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        
        <p>Terima kasih telah melakukan booking di Cars Rent. Berikut detail booking Anda:</p>
        
        <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #1f2937;">Detail Booking</h3>
            <p><strong>ID Booking:</strong> #{{ $booking->id }}</p>
            <p><strong>Mobil:</strong> {{ $booking->car->name }} ({{ $booking->car->brand }})</p>
            <p><strong>Tanggal Sewa:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px;">{{ ucfirst($booking->status) }}</span></p>
        </div>
        
        <p>Silakan lakukan pembayaran sesuai instruksi yang telah diberikan. Setelah pembayaran, admin akan mengkonfirmasi booking Anda.</p>
        
        <p>Jika ada pertanyaan, silakan hubungi kami.</p>
        
        <p>Terima kasih,<br>
        <strong>Tim Cars Rent</strong></p>
    </div>
</body>
</html>