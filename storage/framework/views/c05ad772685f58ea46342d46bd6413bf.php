<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Selamat! Anda Memenangkan Lelang</title>
</head>
<body>
    <h1>Selamat <?php echo e($transaction->winner->name); ?>!</h1>
    
    <p>Anda telah memenangkan lelang untuk barang:</p>
    <h2><?php echo e($auction->title); ?></h2>
    
    <p>Harga akhir: Rp <?php echo e(number_format($transaction->final_price, 0, ',', '.')); ?></p>
    
    <p>Silakan lakukan pembayaran sesuai instruksi yang akan dikirimkan lebih lanjut.</p>
    
    <p>Terima kasih telah menggunakan SILEBAR - Sistem Lelang Barang</p>
</body>
</html><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/emails/auction-won.blade.php ENDPATH**/ ?>