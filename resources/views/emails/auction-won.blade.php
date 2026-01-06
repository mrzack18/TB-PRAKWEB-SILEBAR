<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Selamat! Anda Memenangkan Lelang</title>
</head>
<body>
    <h1>Selamat {{ $transaction->winner->name }}!</h1>
    
    <p>Anda telah memenangkan lelang untuk barang:</p>
    <h2>{{ $auction->title }}</h2>
    
    <p>Harga akhir: Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</p>
    
    <p>Silakan lakukan pembayaran sesuai instruksi yang akan dikirimkan lebih lanjut.</p>
    
    <p>Terima kasih telah menggunakan SILEBAR - Sistem Lelang Barang</p>
</body>
</html>