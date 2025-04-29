<?php
require 'functions.php';

// Menentukan halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIKET!NG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script> <!-- Library Icon -->
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white fixed w-full top-0 left-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <div class="text-xl font-bold">
                    TIKET<span class="text-yellow-400">!NG</span>
                </div>

                <!-- Menu (Desktop) -->
                <div class="hidden md:flex space-x-5 text-base font-medium">
                    <a href="index.php" class="<?= $current_page == 'index.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Beranda</a>
                    <a href="jadwal.php" class="<?= $current_page == 'jadwal.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Jadwal</a>
                    <a href="cart.php" class="<?= $current_page == 'cart.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Pesanan</a>
                    <a href="history.php" class="<?= $current_page == 'history.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Riwayat</a>
                </div>

                <!-- Auth Links -->
                <div class="hidden md:flex space-x-4 items-center">
                    <?php if (isset($_SESSION["username"])) { ?>
                        <span class="font-medium">Hallo, <?= $_SESSION["nama_lengkap"]; ?></span>
                        <a href="logout.php" class="flex items-center bg-red-500 px-3 py-1.5 rounded-lg text-white hover:bg-red-600 transition">
                            Logout 
                            <i data-lucide="log-out" class="ml-2"></i>
                        </a>
                    <?php } else { ?>
                        <a href="auth/login/" class="bg-blue-500 px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">Login</a>
                        <a href="auth/register/" class="bg-yellow-400 px-3 py-1.5 rounded-lg text-blue-800 font-semibold hover:bg-yellow-500 transition">Register</a>
                    <?php } ?>
                </div>

                <!-- Hamburger Menu (Mobile) -->
                <button id="menu-toggle" class="md:hidden focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-blue-700 text-white text-center py-4 space-y-3">
            <a href="index.php" class="block <?= $current_page == 'index.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Beranda</a>
            <a href="jadwal.php" class="block <?= $current_page == 'jadwal.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Jadwal</a>
            <a href="cart.php" class="block <?= $current_page == 'cart.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Pesanan</a>
            <a href="history.php" class="block <?= $current_page == 'history.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Riwayat</a>
            <?php if (isset($_SESSION["username"])) { ?>
                <span class="block font-medium">Hallo, <?= $_SESSION["nama_lengkap"]; ?></span>
                <a href="logout.php" class="block bg-red-500 px-4 py-2 rounded-lg mx-auto w-1/2 hover:bg-red-600 transition">Logout</a>
            <?php } else { ?>
                <a href="auth/login/" class="block bg-blue-500 px-4 py-2 rounded-lg mx-auto w-1/2 hover:bg-blue-700 transition">Login</a>
                <a href="auth/register/" class="block bg-yellow-400 px-4 py-2 rounded-lg text-blue-800 font-semibold mx-auto w-1/2 hover:bg-yellow-500 transition">Register</a>
            <?php } ?>
        </div>
    </nav>

    <!-- Main Content (Padding top untuk menghindari navbar overlap) -->
    <div class="pt-14">
        <!-- Konten halaman di sini -->
    </div>

    <!-- JavaScript untuk Toggle Mobile Menu -->
    <script>
        document.getElementById("menu-toggle").addEventListener("click", function() {
            var menu = document.getElementById("mobile-menu");
            menu.classList.toggle("hidden");
        });

        // Load icons
        lucide.createIcons();
    </script>
</body>
</html>
