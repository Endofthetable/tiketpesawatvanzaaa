<?php require 'layouts/navbar.php'; ?>
<?php 
$id = $_GET["id"];
$jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai WHERE id_jadwal = '$id'")[0];
?>

<div class="flight-detail-container py-12 px-4 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- Header with back button -->
        <div class="flex items-center mb-8 animate-fade-in-down">
            <a href="index.php" class="flex items-center text-blue-600 hover:text-blue-800 transition transform hover:-translate-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Flights
            </a>
        </div>

        <!-- Main card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 transform transition-all duration-300 hover:shadow-md animate-fade-in-up">
            <!-- Airline header -->
            <div class="bg-blue-50 px-6 py-4 border-b border-gray-200 flex items-center animate-pulse-once">
                <img src="assets/images/<?= $jadwalPenerbangan["logo_maskapai"]; ?>" alt="<?= $jadwalPenerbangan["nama_maskapai"]; ?>" class="h-10 w-10 object-contain mr-4 transform transition duration-300 hover:scale-110">
                <h2 class="text-xl font-bold text-gray-800"><?= $jadwalPenerbangan["nama_maskapai"]; ?></h2>
                <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full transition duration-200 hover:bg-blue-200 hover:text-blue-900">
                    <?= $jadwalPenerbangan["kapasitas_kursi"]; ?> seats available
                </span>
            </div>

            <div class="p-6">
                <!-- Flight route visualization -->
                <div class="flex items-center justify-between mb-8">
                    <div class="text-center transform transition duration-300 hover:scale-105">
                        <div class="text-2xl font-bold text-gray-900 animate-bounce-in"><?= date('H:i', strtotime($jadwalPenerbangan["waktu_berangkat"])); ?></div>
                        <div class="text-sm text-gray-500 mt-1 animate-fade-in"><?= $jadwalPenerbangan["rute_asal"]; ?></div>
                    </div>

                    <div class="flex flex-col items-center px-4">
                        <div class="text-xs text-gray-500 mb-1 animate-fade-in">
                            <?= date('d M Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?>
                        </div>
                        <div class="relative w-32">
                            <div class="h-px w-full bg-gray-300 animate-line-extend"></div>
                            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 animate-float">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 animate-fade-in">
                            <?= floor((strtotime($jadwalPenerbangan["waktu_tiba"]) - strtotime($jadwalPenerbangan["waktu_berangkat"]))/3600) ?>h 
                            <?= floor((strtotime($jadwalPenerbangan["waktu_tiba"]) - strtotime($jadwalPenerbangan["waktu_berangkat"]))%3600/60) ?>m
                        </div>
                    </div>

                    <div class="text-center transform transition duration-300 hover:scale-105">
                        <div class="text-2xl font-bold text-gray-900 animate-bounce-in" style="animation-delay: 0.2s"><?= date('H:i', strtotime($jadwalPenerbangan["waktu_tiba"])); ?></div>
                        <div class="text-sm text-gray-500 mt-1 animate-fade-in"><?= $jadwalPenerbangan["rute_tujuan"]; ?></div>
                    </div>
                </div>

                <!-- Flight details grid -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="flex items-start animate-fade-in-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <div class="text-sm text-gray-500">Departure Date</div>
                            <div class="font-medium"><?= date('l, d F Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?></div>
                        </div>
                    </div>
                    
                    <div class="flex items-start animate-fade-in-right">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <div class="text-sm text-gray-500">Flight Duration</div>
                            <div class="font-medium">
                                <?= floor((strtotime($jadwalPenerbangan["waktu_tiba"]) - strtotime($jadwalPenerbangan["waktu_berangkat"]))/3600) ?>h 
                                <?= floor((strtotime($jadwalPenerbangan["waktu_tiba"]) - strtotime($jadwalPenerbangan["waktu_berangkat"]))%3600/60) ?>m
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-start animate-fade-in-left" style="animation-delay: 0.1s">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <div class="text-sm text-gray-500">From</div>
                            <div class="font-medium"><?= $jadwalPenerbangan["rute_asal"]; ?></div>
                        </div>
                    </div>
                    
                    <div class="flex items-start animate-fade-in-right" style="animation-delay: 0.1s">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <div class="text-sm text-gray-500">To</div>
                            <div class="font-medium"><?= $jadwalPenerbangan["rute_tujuan"]; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Price and booking section -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 transform transition-all duration-300 hover:shadow-inner animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="transform transition duration-300 hover:scale-105">
                            <div class="text-sm text-gray-500">Price per ticket</div>
                            <div class="text-2xl font-bold text-blue-600 animate-pulse-once" style="animation-delay: 0.4s">Rp <?= number_format($jadwalPenerbangan["harga"], 0, ',', '.'); ?></div>
                        </div>
                        <div class="text-right transform transition duration-300 hover:scale-105">
                            <div class="text-sm text-gray-500">Available seats</div>
                            <div class="font-medium"><?= $jadwalPenerbangan["kapasitas_kursi"]; ?></div>
                        </div>
                    </div>

                    <form action="" method="POST" class="flex items-end justify-between">
                        <div class="flex-1 mr-4 animate-fade-in-left" style="animation-delay: 0.3s">
                            <label for="qty" class="block text-sm font-medium text-gray-700 mb-1">Number of tickets</label>
                            <div class="relative flex items-center">
                                <button type="button" class="decrement-btn px-3 py-2 bg-gray-200 rounded-l-lg text-gray-600 hover:bg-gray-300 focus:outline-none transition duration-200 active:bg-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" name="qty" value="1" min="1" max="<?= $jadwalPenerbangan["kapasitas_kursi"]; ?>" 
                                    class="quantity-input w-full px-4 py-2 text-center border-t border-b border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" class="increment-btn px-3 py-2 bg-gray-200 rounded-r-lg text-gray-600 hover:bg-gray-300 focus:outline-none transition duration-200 active:bg-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" name="pesan" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center transition duration-300 transform hover:scale-105 hover:shadow-lg animate-pulse-once" style="animation-delay: 0.5s">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Quantity input controls with animation
    document.querySelector('.decrement-btn').addEventListener('click', function() {
        const input = document.querySelector('.quantity-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            // Add click animation
            this.classList.add('animate-click');
            setTimeout(() => {
                this.classList.remove('animate-click');
            }, 300);
        }
    });

    document.querySelector('.increment-btn').addEventListener('click', function() {
        const input = document.querySelector('.quantity-input');
        const max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
            // Add click animation
            this.classList.add('animate-click');
            setTimeout(() => {
                this.classList.remove('animate-click');
            }, 300);
        }
    });
</script>

<?php
if(isset($_POST["pesan"])){
    if($_POST["qty"] > $jadwalPenerbangan["kapasitas_kursi"]){
        echo "
            <script type='text/javascript'>
                alert('The quantity you ordered exceeds available seats!');
                window.location = 'index.php';
            </script>
        ";
    }else if($_POST["qty"] <= 0){
        echo "
            <script type='text/javascript'>
                alert('Please order at least 1 ticket!');
                window.location = 'index.php';
            </script>
        ";
    }else{
        $qty = $_POST["qty"];
        $_SESSION["cart"][$id] = $qty;
        echo "
            <script type='text/javascript'>
                window.location = 'cart.php';
            </script>
        ";    
    }
}
?>

<style>
    .flight-detail-container {
        font-family: 'Inter', sans-serif;
    }
    
    .quantity-input {
        -moz-appearance: textfield;
    }
    
    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0) translateX(-50%);
        }
        50% {
            transform: translateY(-5px) translateX(-50%);
        }
    }
    
    @keyframes pulseOnce {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    
    @keyframes lineExtend {
        from {
            width: 0;
        }
        to {
            width: 100%;
        }
    }
    
    @keyframes click {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Animation classes */
    .animate-fade-in-down {
        animation: fadeInDown 0.6s ease-out forwards;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .animate-fade-in-left {
        animation: fadeInLeft 0.6s ease-out forwards;
    }
    
    .animate-fade-in-right {
        animation: fadeInRight 0.6s ease-out forwards;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    .animate-bounce-in {
        animation: bounceIn 0.6s ease-out forwards;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    .animate-pulse-once {
        animation: pulseOnce 0.6s ease-out forwards;
    }
    
    .animate-line-extend {
        animation: lineExtend 0.8s ease-out forwards;
    }
    
    .animate-click {
        animation: click 0.3s ease-out;
    }
</style>