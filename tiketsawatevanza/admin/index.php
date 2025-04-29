<?php
$page = "Dashboard";
session_start();

if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
    alert('Silahkan login terlebih dahulu');
    window.location ='../auth/login/';
    </script>
    ";
}

// Assuming you have database connection here
require '../koneksi.php';
$user_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM user");
$user_count = mysqli_fetch_assoc($user_count)['total'];

$flight_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM jadwal_penerbangan");
$flight_count = mysqli_fetch_assoc($flight_count)['total'];

$airline_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM maskapai");
$airline_count = mysqli_fetch_assoc($airline_count)['total'];

$town_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM kota");
$town_count = mysqli_fetch_assoc($town_count)['total'];

$route_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM rute");
$route_count = mysqli_fetch_assoc($route_count)['total'];

$order_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM order_tiket");
$order_count = mysqli_fetch_assoc($order_count)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3f37c9;
            --dark: #1e1e1e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: var(--dark);
        }
        
        /* Animation classes */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .animate-fade {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        
        .delay-100 {
            animation-delay: 0.1s;
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
        
        .delay-300 {
            animation-delay: 0.3s;
        }
        
        /* Main content */
        .main-content {
            transition: margin-left 0.3s;
        }
        
        .greeting {
            color: var(--dark);
            margin-bottom: 1.5rem;
        }
        
        .greeting small {
            color: var(--gray);
            font-weight: 400;
            display: block;
            margin-top: 0.5rem;
        }
        
        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card.users {
            border-left-color: var(--primary);
        }
        
        .stat-card.flights {
            border-left-color: var(--success);
        }
        
        .stat-card.airlines {
            border-left-color: var(--warning);
        }
        
        .stat-card.towns {
            border-left-color: var(--danger);
        }
        
        .stat-card.routes {
            border-left-color: #7209b7;
        }
        
        .stat-card.orders {
            border-left-color: #4895ef;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.25rem;
        }
        
        .stat-card.users .stat-icon {
            background-color: var(--primary);
        }
        
        .stat-card.flights .stat-icon {
            background-color: var(--success);
        }
        
        .stat-card.airlines .stat-icon {
            background-color: var(--warning);
        }
        
        .stat-card.towns .stat-icon {
            background-color: var(--danger);
        }
        
        .stat-card.routes .stat-icon {
            background-color: #7209b7;
        }
        
        .stat-card.orders .stat-icon {
            background-color: #4895ef;
        }
        
        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            color: var(--gray);
        }
        
        .stat-change i {
            margin-right: 0.25rem;
        }
        
        .up {
            color: #4ade80;
        }
        
        .down {
            color: var(--danger);
        }
    </style>
</head>
<body>
    <?php require '../layouts/sidebar.php'; ?>

    <div class="main-content flex-1 p-6">
        <div class="greeting animate-fade">
            <h1 class="text-2xl font-bold">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
            <small>Selamat datang kembali di sistem manajemen penerbangan</small>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card users animate-fade delay-100">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value"><?= $user_count; ?></div>
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up up"></i>
                    <span>12% dari bulan lalu</span>
                </div>
            </div>
            
            <div class="stat-card flights animate-fade delay-200">
                <div class="stat-icon">
                    <i class="fas fa-plane"></i>
                </div>
                <div class="stat-value"><?= $flight_count; ?></div>
                <div class="stat-label">Jadwal Penerbangan</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up up"></i>
                    <span>5% dari bulan lalu</span>
                </div>
            </div>
            
            <div class="stat-card airlines animate-fade delay-300">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-value"><?= $airline_count; ?></div>
                <div class="stat-label">Maskapai Penerbangan</div>
                <div class="stat-change">
                    <i class="fas fa-equals"></i>
                    <span>Stabil</span>
                </div>
            </div>
            
            <div class="stat-card towns animate-fade delay-100">
                <div class="stat-icon">
                    <i class="fas fa-city"></i>
                </div>
                <div class="stat-value"><?= $town_count; ?></div>
                <div class="stat-label">Kota Tersedia</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up up"></i>
                    <span>2 kota baru</span>
                </div>
            </div>
            
            <div class="stat-card routes animate-fade delay-200">
                <div class="stat-icon">
                    <i class="fas fa-route"></i>
                </div>
                <div class="stat-value"><?= $route_count; ?></div>
                <div class="stat-label">Rute Penerbangan</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up up"></i>
                    <span>8% dari bulan lalu</span>
                </div>
            </div>
            
            <div class="stat-card orders animate-fade delay-300">
                <div class="stat-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-value"><?= $order_count; ?></div>
                <div class="stat-label">Pemesanan Tiket</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up up"></i>
                    <span>15% dari bulan lalu</span>
                </div>
            </div>
        </div>
        
        <!-- You can add more sections here like recent activities, charts, etc. -->
    </div>

    <script>
        // Simple animation trigger when elements come into view
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.stat-card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>