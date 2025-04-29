<?php 
require 'layouts/navbar.php';

if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = 'index.php';
    </script>
    ";
}
?> 

<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Checkout Progress Bar -->
    <div class="mb-12">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span class="text-blue-600 font-medium"><i class="fas fa-shopping-cart mr-1"></i> Cart</span>
            <span class="text-blue-600 font-medium"><i class="fas fa-clipboard-check mr-1"></i> Checkout</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <?php if(empty($_SESSION["cart"])) { ?>
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-shopping-cart text-3xl text-blue-500"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Kosong</h1>
            <p class="text-gray-600 mb-6">Belum ada tiket yang kamu pesan</p>
            <a href="index.php" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                <i class="fas fa-search mr-2"></i> Cari Tiket
            </a>
        </div>
    <?php } else { ?>
        <form action="" method="POST">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Order Summary -->
                <div class="md:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-clipboard-check text-blue-500 mr-3"></i> Checkout Pemesanan
                        </h1>
                    </div>

                    <div class="p-6">
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-circle text-blue-500 mr-2"></i> Informasi Pemesan
                            </h2>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <input type="hidden" name="id_user" value="<?= $_SESSION["id_user"]; ?>">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700"><?= $_SESSION["nama_lengkap"]; ?></p>
                                        <p class="text-sm text-gray-500"><?= $_SESSION["username"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-ticket-alt text-blue-500 mr-2"></i> Detail Tiket
                            </h2>
                            
                            <div class="space-y-4">
                                <?php $grandTotal = 0; ?>
                                <?php foreach($_SESSION["cart"] as $id_tiket => $kuantitas) : ?>
                                    <?php 
                                    $tiket = query("SELECT * FROM jadwal_penerbangan 
                                                    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                                    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                                    WHERE id_jadwal = '$id_tiket'")[0]; 
                                    $totalHarga = $tiket["harga"] * $kuantitas;
                                    $grandTotal += $totalHarga;
                                    ?>
                                    <input type="hidden" name="id_penerbangan[]" value="<?= $id_tiket; ?>">
                                    <input type="hidden" name="jumlah_tiket[]" value="<?= $kuantitas; ?>">
                                    <input type="hidden" name="total_harga[]" value="<?= $totalHarga; ?>">
                                    
                                    <div class="border border-gray-100 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-300">
                                        <div class="p-4 flex items-start">
                                            <img src="assets/images/<?= $tiket["logo_maskapai"]; ?>" width="60" class="rounded-md mr-4">
                                            <div class="flex-1">
                                                <div class="flex justify-between">
                                                    <h3 class="font-bold text-gray-800"><?= $tiket["nama_maskapai"]; ?></h3>
                                                    <span class="text-blue-600 font-bold">Rp <?= number_format($totalHarga); ?></span>
                                                </div>
                                                <p class="text-sm text-gray-500 mb-2"><?= $tiket["rute_asal"]; ?> → <?= $tiket["rute_tujuan"]; ?></p>
                                                
                                                <div class="grid grid-cols-2 gap-4 text-sm mt-3">
                                                    <div>
                                                        <p class="text-gray-500">Tanggal</p>
                                                        <p class="font-medium"><?= date('d M Y', strtotime($tiket["tanggal_pergi"])); ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-500">Waktu</p>
                                                        <p class="font-medium"><?= $tiket["waktu_berangkat"]; ?> - <?= $tiket["waktu_tiba"]; ?></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3 flex items-center text-sm">
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">
                                                        <?= $kuantitas; ?> Tiket
                                                    </span>
                                                    <span class="text-gray-600">
                                                        Rp <?= number_format($tiket["harga"]); ?>/tiket
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="h-fit sticky top-6">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-receipt text-blue-500 mr-2"></i> Ringkasan Pesanan
                            </h2>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-3">
                                <?php foreach($_SESSION["cart"] as $id_tiket => $kuantitas) : ?>
                                    <?php 
                                    $tiket = query("SELECT * FROM jadwal_penerbangan 
                                                    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                                    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                                    WHERE id_jadwal = '$id_tiket'")[0]; 
                                    $totalHarga = $tiket["harga"] * $kuantitas;
                                    ?>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600"><?= $tiket["nama_maskapai"]; ?> (x<?= $kuantitas; ?>)</span>
                                        <span>Rp <?= number_format($totalHarga); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="border-t border-gray-200 my-4"></div>
                            
                            <div class="flex justify-between font-medium mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span>Rp <?= number_format($grandTotal); ?></span>
                            </div>
                            <div class="flex justify-between font-medium mb-2">
                                <span class="text-gray-600">Pajak & Layanan</span>
                                <span>Rp 0</span>
                            </div>
                            
                            <div class="border-t border-gray-200 my-4"></div>
                            
                            <div class="flex justify-between items-center mb-6">
                                <span class="font-bold text-gray-800">Total Pembayaran</span>
                                <span class="text-xl font-bold text-blue-600">Rp <?= number_format($grandTotal); ?></span>
                            </div>
                            
                            <button type="submit" name="checkout" 
                                    class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 shadow-md flex items-center justify-center">
                                <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-4 bg-blue-50 p-4 rounded-lg text-sm text-blue-800 flex items-start">
                        <i class="fas fa-info-circle mr-2 mt-1"></i>
                        <span>Pesanan Anda akan diproses setelah pembayaran berhasil diverifikasi</span>
                    </div>
                </div>
            </div>
        </form>
    <?php } ?>
</div>

<?php
if (isset($_POST['checkout'])) {
    // Process each ticket in the cart
    foreach($_SESSION["cart"] as $id_tiket => $kuantitas) {
        $tiket = query("SELECT * FROM jadwal_penerbangan 
                        INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                        INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                        WHERE id_jadwal = '$id_tiket'")[0];
        
        $totalHarga = $tiket["harga"] * $kuantitas;
        
        // Prepare data for checkout function
        $checkoutData = [
            'id_user' => $_POST['id_user'],
            'id_penerbangan' => $id_tiket,
            'jumlah_tiket' => $kuantitas,
            'total_harga' => $totalHarga
        ];
        
        if (!checkout($checkoutData)) {
            echo mysqli_error($conn);
            exit;
        }
    }
    
    // Clear cart after successful checkout
    unset($_SESSION["cart"]);
    
    echo "
    <script type='text/javascript'>
        alert('Berhasil! Pesanan telah dibuat.');
        window.location = 'history.php';
    </script>";
}
?>