<?php
require 'koneksi.php'; // Mengimpor koneksi database

// Handle Edit
if (isset($_POST['edit'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $kuantitas = $_POST['kuantitas'];

    // Update kuantitas dalam cart
    $_SESSION['cart'][$id_jadwal] = $kuantitas;

    // Redirect kembali ke halaman cart
    header('Location: cart.php');
    exit;
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_jadwal'])) {
    $id_jadwal = $_GET['id_jadwal'];

    // Hapus item dari cart
    unset($_SESSION['cart'][$id_jadwal]);

    // Redirect kembali ke halaman cart
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | AirTravel</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .progress-bar {
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }
        .progress {
            height: 100%;
            background-color: #3b82f6;
            transition: width 0.6s ease;
        }
        .flight-icon {
            transform: rotate(45deg);
            color: #3b82f6;
        }
        .cart-item {
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .empty-cart {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="font-sans bg-gray-50">

<?php require 'layouts/navbar.php'; ?>

<div class="container mx-auto py-8 px-4 max-w-7xl">
<div class="mb-12">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span class="text-blue-600 font-medium"><i class="fas fa-shopping-cart mr-1"></i> Cart</span>
            <span class="font-medium"><i class="fas fa-clipboard-check mr-1"></i> Checkout</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-shopping-cart mr-2"></i> My Cart
        </h1>
        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
            <?php echo count($_SESSION["cart"] ?? []); ?> items
        </span>
    </div>

    <?php if (empty($_SESSION["cart"])): ?>
        <div class="empty-cart text-center py-16 bg-white rounded-xl shadow-sm">
            <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4"></i>
            <h2 class="text-xl font-medium text-gray-600 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6">Looks like you haven't added any flights yet</p>
            <a href="index.php" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors animate__animated animate__fadeIn">
                <i class="fas fa-search mr-2"></i> Browse Flights
            </a>
        </div>
    <?php else: ?>
        <div class="grid gap-6">
            <!-- Flight Items -->
            <div class="space-y-4">
                <?php $no = 1; ?>
                <?php $grandTotal = 0; ?>
                <?php foreach ($_SESSION["cart"] as $id_jadwal => $kuantitas) : ?>
                <?php
                $jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
                INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai WHERE id_jadwal = '$id_jadwal'")[0];
                
                $totalHarga = $jadwalPenerbangan["harga"] * $kuantitas;
                $grandTotal += $totalHarga;
                ?>
                <div class="cart-item bg-white rounded-xl shadow-sm overflow-hidden animate__animated animate__fadeIn">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <div class="mr-4 text-center">
                                    <div class="flight-icon text-2xl">
                                        <i class="fas fa-plane"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 mt-1 block">Flight <?= $no; ?></span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg"><?= $jadwalPenerbangan["nama_maskapai"]; ?></h3>
                                    <p class="text-gray-600 text-sm"><?= $jadwalPenerbangan["rute_asal"]; ?> → <?= $jadwalPenerbangan["rute_tujuan"]; ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-semibold">Rp <?= number_format($totalHarga); ?></span>
                                <p class="text-gray-500 text-sm"><?= $kuantitas; ?> x Rp <?= number_format($jadwalPenerbangan["harga"]); ?></p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Departure</p>
                                <p class="font-medium"><?= date('d M Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?></p>
                                <p><?= date('H:i', strtotime($jadwalPenerbangan["waktu_berangkat"])); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-500">Arrival</p>
                                <p class="font-medium"><?= date('d M Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?></p>
                                <p><?= date('H:i', strtotime($jadwalPenerbangan["waktu_tiba"])); ?></p>
                            </div>
                            <div class="flex items-end justify-between">
                                <form action="edit_cart.php" method="POST" class="flex items-center">
                                    <input type="number" name="kuantitas" value="<?= $kuantitas; ?>" min="1" 
                                        class="w-16 text-center border border-gray-300 p-1 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                                    <button type="submit" name="edit" class="ml-2 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                <a href="cart.php?action=delete&id_jadwal=<?= $id_jadwal; ?>" 
                                   class="text-red-500 hover:text-red-700"
                                   onclick="return confirm('Are you sure you want to remove this item?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $no++; ?>
                <?php endforeach; ?>
            </div>

            <!-- Summary -->
            <div class="bg-white rounded-xl shadow-sm p-6 animate__animated animate__fadeInUp">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Order Summary</h3>
                    <span class="text-sm text-gray-500"><?= count($_SESSION["cart"]); ?> items</span>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp <?= number_format($grandTotal); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Taxes & Fees</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-blue-600">Rp <?= number_format($grandTotal); ?></span>
                    </div>
                </div>

                <a href="checkout.php" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition-colors shadow-md">
                    <i class="fas fa-credit-card mr-2"></i> Proceed to Checkout
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    // Simple animation trigger
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.cart-item');
        items.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>

</body>
</html>