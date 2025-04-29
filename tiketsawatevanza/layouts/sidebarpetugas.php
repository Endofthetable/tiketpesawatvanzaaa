<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Dashboard Petugas</title>
    <style>
        /* Custom animations */
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .sidebar-item {
            transition: all 0.3s ease;
            transform-origin: left center;
        }
        
        .sidebar-item:hover {
            transform: translateX(5px);
        }
        
        .logo-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</head>
<body class="flex">
    <!-- Enhanced Sidebar -->
    <div class="bg-gradient-to-b from-blue-600 to-blue-700 shadow-lg h-screen w-64 p-6 text-white flex flex-col transition-all duration-300">
        <!-- Logo with animation -->
        <div class="text-2xl font-bold mb-8 flex items-center logo-float">
            <i class="fas fa-plane-departure text-yellow-300 mr-2"></i>
            <span>TIKET<span class="text-yellow-300">!NG</span></span>
        </div>
        
        <nav class="flex-1 space-y-2">
            <!-- Dashboard -->
            <a href="/petugas/index.php" 
               class="sidebar-item flex items-center py-3 px-4 rounded-lg hover:bg-blue-500/30 hover:shadow-md animate__animated animate__fadeInLeft <?php if($page == "dashboard") echo "bg-blue-500/40 shadow-md" ?>"
               style="animation-delay: 0.1s">
                <i class="fas fa-tachometer-alt w-6 text-center mr-3 <?php if($page == "dashboard") echo "text-yellow-300" ?>"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Flight Schedule -->
            <a href="/petugas/jadwal/" 
               class="sidebar-item flex items-center py-3 px-4 rounded-lg hover:bg-blue-500/30 hover:shadow-md animate__animated animate__fadeInLeft <?php if($page == "Jadwal") echo "bg-blue-500/40 shadow-md" ?>"
               style="animation-delay: 0.2s">
                <i class="fas fa-calendar-alt w-6 text-center mr-3 <?php if($page == "Jadwal") echo "text-yellow-300" ?>"></i>
                <span>Data Jadwal</span>
            </a>
            
            <!-- Ticket Orders -->
            <a href="/petugas/order/" 
               class="sidebar-item flex items-center py-3 px-4 rounded-lg hover:bg-blue-500/30 hover:shadow-md animate__animated animate__fadeInLeft <?php if($page == "Tiket") echo "bg-blue-500/40 shadow-md" ?>"
               style="animation-delay: 0.3s">
                <i class="fas fa-ticket-alt w-6 text-center mr-3 <?php if($page == "Tiket") echo "text-yellow-300" ?>"></i>
                <span>Pemesanan Tiket</span>
            </a>
        </nav>
        
        <!-- Logout Button -->
        <div class="mt-auto pt-4 border-t border-blue-500/30">
            <a href="/logout.php" 
               onClick="return confirm('Apakah anda yakin ingin logout?')"
               class="sidebar-item flex items-center py-3 px-4 rounded-lg hover:bg-red-500/30 hover:shadow-md animate__animated animate__fadeInLeft"
               style="animation-delay: 0.4s">
                <i class="fas fa-sign-out-alt w-6 text-center mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
        
        <!-- Current User (optional) -->
        <div class="mt-4 pt-4 border-t border-blue-500/30 text-sm text-blue-200 animate__animated animate__fadeInUp">
            <div class="flex items-center">
                <i class="fas fa-user-circle mr-2"></i>
                <span><?php echo $_SESSION['nama_lengkap'] ?? 'Petugas'; ?></span>
            </div>
        </div>
    </div>

    <script>
        // Add animation class to items on hover
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.classList.add('animate__pulse');
                setTimeout(() => {
                    this.classList.remove('animate__pulse');
                }, 1000);
            });
        });
    </script>
</body>
</html>