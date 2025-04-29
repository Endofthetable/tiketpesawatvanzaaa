<?php    
    $page = "dashboard";
    session_start();
    
    // Database connection (adjust credentials as needed)
    require '../koneksi.php';
    
    // Get flight schedule count
    $flightQuery = "SELECT COUNT(*) as total FROM jadwal_penerbangan";
    $flightResult = mysqli_query($conn, $flightQuery);
    $flightData = mysqli_fetch_assoc($flightResult);
    $flightCount = $flightData['total'];
    
    // Get ticket orders count
    $orderQuery = "SELECT COUNT(*) as total FROM order_tiket";
    $orderResult = mysqli_query($conn, $orderQuery);
    $orderData = mysqli_fetch_assoc($orderResult);
    $orderCount = $orderData['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Petugas</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* Custom animations */
        @keyframes float {
            0%, 100% { 
                transform: translateY(0); 
            }
            50% { 
                transform: translateY(-8px); 
            }
        }
        
        @keyframes fadeInSlide {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            transform: translateY(0);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.1);
        }
        
        .transition-all {
            transition: all 0.4s ease;
        }
        
        .fade-in-slide {
            animation: fadeInSlide 0.8s ease-out forwards;
        }
        
        .delay-100 {
            animation-delay: 0.1s;
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen">
        <?php require '../layouts/sidebarpetugas.php'; ?>
        
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-8 fade-in-slide">
                    <h1 class="text-3xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
                    <p class="text-gray-600 mt-2">Selamat datang di dashboard petugas</p>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Flight Schedule Card -->
                    <div class="bg-white rounded-xl shadow-md p-6 card-hover fade-in-slide delay-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-plane-departure text-2xl float-animation"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Jadwal Penerbangan</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $flightCount ?></h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="/petugas/jadwal/" class="text-blue-500 hover:text-blue-700 text-sm font-medium transition-all flex items-center">
                                Lihat Semua <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Ticket Orders Card -->
                    <div class="bg-white rounded-xl shadow-md p-6 card-hover fade-in-slide delay-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-ticket-alt text-2xl float-animation" style="animation-delay: 0.3s"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Pesanan Tiket</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $orderCount ?></h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="/petugas/order/" class="text-green-500 hover:text-green-700 text-sm font-medium transition-all flex items-center">
                                Lihat Semua <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-md p-6 fade-in-slide" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Aktivitas Terbaru</h2>
                        <a href="#" class="text-sm text-blue-500 hover:text-blue-700 transition-colors">Lihat Semua</a>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-all duration-300 hover:shadow-sm">
                            <div class="bg-purple-100 text-purple-600 p-2 rounded-full mr-3">
                                <i class="fas fa-user-plus text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Pemesanan baru diterima</p>
                                <p class="text-xs text-gray-500 mt-1">10 menit yang lalu</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                        </div>
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-all duration-300 hover:shadow-sm">
                            <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full mr-3">
                                <i class="fas fa-plane text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Jadwal penerbangan diperbarui</p>
                                <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll to top on page load
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Add hover effect to arrow icons
            document.querySelectorAll('a[href]').forEach(link => {
                if (link.querySelector('.fa-arrow-right')) {
                    link.classList.add('group');
                }
            });
        });
    </script>
</body>
</html> 