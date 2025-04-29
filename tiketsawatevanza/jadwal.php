<?php require 'layouts/navbar.php'; ?>
<?php 
$jadwalPenerbangan = query("SELECT jadwal_penerbangan.*, rute.*, maskapai.*, jadwal_penerbangan.kapasitas_kursi 
FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
ORDER BY tanggal_pergi, waktu_berangkat");

// Get unique airlines for filter
$maskapaiList = query("SELECT DISTINCT nama_maskapai, logo_maskapai FROM maskapai ORDER BY nama_maskapai");
// Get unique routes for filter
$ruteList = query("SELECT DISTINCT rute_asal, rute_tujuan FROM rute ORDER BY rute_asal");
?>

<div class="flight-schedule-container py-8 px-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 transform transition-all duration-500 hover:scale-105 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 inline-block mr-2 text-blue-500 animate-float" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            Flight Schedules
        </h1>
        
        <!-- Expanded Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 transform transition-all duration-300 hover:shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search by Route -->
                <div class="filter-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Route
                    </label>
                    <select id="routeFilter" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200 hover:border-blue-300">
                        <option value="">All Routes</option>
                        <?php foreach($ruteList as $rute): ?>
                            <option value="<?= $rute['rute_asal'] ?>-<?= $rute['rute_tujuan'] ?>">
                                <?= $rute['rute_asal'] ?> → <?= $rute['rute_tujuan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Filter by Airline -->
                <div class="filter-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Airline
                    </label>
                    <select id="airlineFilter" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200 hover:border-blue-300">
                        <option value="">All Airlines</option>
                        <?php foreach($maskapaiList as $maskapai): ?>
                            <option value="<?= $maskapai['nama_maskapai'] ?>">
                                <?= $maskapai['nama_maskapai'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Filter by Date -->
                <div class="filter-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Date
                    </label>
                    <input type="date" id="dateFilter" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200 hover:border-blue-300">
                </div>
                
                <!-- Filter by Price Range -->
                <div class="filter-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Price Range
                    </label>
                    <div class="flex items-center space-x-2">
                        <input type="number" id="priceMin" placeholder="Min" class="w-1/2 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200 hover:border-blue-300">
                        <span class="text-gray-500">to</span>
                        <input type="number" id="priceMax" placeholder="Max" class="w-1/2 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200 hover:border-blue-300">
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end space-x-2">
                <button id="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    Reset
                </button>
                <button id="applyFilters" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Apply Filters
                </button>
            </div>
        </div>

        <!-- Flight Cards -->
        <div id="flightCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($jadwalPenerbangan as $index => $data): ?>
            <div class="flight-card bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 transform hover:-translate-y-1.5 animate-fade-in-up" 
                 style="animation-delay: <?= $index * 0.05 ?>s"
                 data-route="<?= $data['rute_asal'] ?>-<?= $data['rute_tujuan'] ?>"
                 data-airline="<?= $data['nama_maskapai'] ?>"
                 data-date="<?= date('Y-m-d', strtotime($data['tanggal_pergi'])) ?>"
                 data-price="<?= $data['harga'] ?>">
                <a href="detail.php?id=<?= $data["id_jadwal"]; ?>" class="block">
                    <div class="p-5">
                        <!-- Airline Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <img src="assets/images/<?= $data["logo_maskapai"]; ?>" class="h-8 w-8 object-contain mr-3 transition duration-300 hover:scale-110" alt="<?= $data["nama_maskapai"]; ?>">
                                <span class="font-medium text-gray-900 hover:text-blue-600 transition duration-200"><?= $data["nama_maskapai"]; ?></span>
                            </div>
                            <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full transition duration-200 hover:bg-blue-200">
                                <?= $data["kapasitas_kursi"]; ?> seats left
                            </span>
                        </div>
                        
                        <!-- Flight Route and Time -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-center">
                                <div class="text-xl font-bold text-gray-900 hover:text-blue-600 transition duration-200"><?= date('H:i', strtotime($data["waktu_berangkat"])); ?></div>
                                <div class="text-xs text-gray-500"><?= $data["rute_asal"] ?></div>
                            </div>
                            
                            <div class="flex flex-col items-center px-2">
                                <div class="text-xs text-gray-500 mb-1">
                                    <?= date('d M', strtotime($data["tanggal_pergi"])); ?>
                                </div>
                                <div class="relative">
                                    <div class="h-px w-16 bg-gray-300"></div>
                                    <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 animate-pulse">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?= floor((strtotime($data["waktu_tiba"]) - strtotime($data["waktu_berangkat"]))/3600) ?>h
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <div class="text-xl font-bold text-gray-900 hover:text-blue-600 transition duration-200"><?= date('H:i', strtotime($data["waktu_tiba"])); ?></div>
                                <div class="text-xs text-gray-500"><?= $data["rute_tujuan"]; ?></div>
                            </div>
                        </div>
                        
                        <!-- Progress bar for seat availability -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Seat availability</span>
                                <span><?= rand(70, 95); ?>% full</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-1000 ease-out" style="width: <?= rand(70, 95); ?>%"></div>
                            </div>
                        </div>
                        
                        <!-- Price and Book Button -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="transform hover:scale-105 transition duration-200">
                                <span class="text-sm text-gray-500">From</span>
                                <div class="text-xl font-bold text-blue-600">Rp <?= number_format($data["harga"], 0, ',', '.'); ?></div>
                            </div>
                            <button class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition duration-200 transform hover:scale-105 active:scale-95 flex items-center shadow-md hover:shadow-lg">
                                Book Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- No results message (hidden by default) -->
        <div id="noResultsMessage" class="text-center py-12 hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-medium text-gray-700">No flights found</h3>
            <p class="text-gray-500 mt-2">Try adjusting your search filters</p>
        </div>
        
        <!-- Pagination would go here -->
        <div class="mt-8 flex justify-center">
            <nav class="inline-flex rounded-md shadow">
                <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 transition duration-200 transform hover:-translate-y-0.5">
                    Previous
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50 transition duration-200 transform hover:-translate-y-0.5">
                    1
                </a>
                <a href="#" class="px-3 py-2 border border-gray-300 bg-blue-500 text-white transition duration-200 transform hover:-translate-y-0.5">
                    2
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50 transition duration-200 transform hover:-translate-y-0.5">
                    3
                </a>
                <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 transition duration-200 transform hover:-translate-y-0.5">
                    Next
                </a>
            </nav>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyFiltersBtn = document.getElementById('applyFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const flightCards = document.querySelectorAll('.flight-card');
    const flightContainer = document.getElementById('flightCardsContainer');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    applyFiltersBtn.addEventListener('click', function() {
        const routeFilter = document.getElementById('routeFilter').value.toLowerCase();
        const airlineFilter = document.getElementById('airlineFilter').value.toLowerCase();
        const dateFilter = document.getElementById('dateFilter').value;
        const priceMin = parseFloat(document.getElementById('priceMin').value) || 0;
        const priceMax = parseFloat(document.getElementById('priceMax').value) || Infinity;
        
        let hasVisibleCards = false;
        
        flightCards.forEach(card => {
            const cardRoute = card.getAttribute('data-route').toLowerCase();
            const cardAirline = card.getAttribute('data-airline').toLowerCase();
            const cardDate = card.getAttribute('data-date');
            const cardPrice = parseFloat(card.getAttribute('data-price'));
            
            const routeMatch = !routeFilter || cardRoute.includes(routeFilter);
            const airlineMatch = !airlineFilter || cardAirline.includes(airlineFilter);
            const dateMatch = !dateFilter || cardDate === dateFilter;
            const priceMatch = cardPrice >= priceMin && cardPrice <= priceMax;
            
            if (routeMatch && airlineMatch && dateMatch && priceMatch) {
                card.style.display = 'block';
                hasVisibleCards = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (hasVisibleCards) {
            noResultsMessage.classList.add('hidden');
            flightContainer.classList.remove('hidden');
        } else {
            noResultsMessage.classList.remove('hidden');
            flightContainer.classList.add('hidden');
        }
    });
    
    resetFiltersBtn.addEventListener('click', function() {
        // Reset all filter inputs
        document.getElementById('routeFilter').value = '';
        document.getElementById('airlineFilter').value = '';
        document.getElementById('dateFilter').value = '';
        document.getElementById('priceMin').value = '';
        document.getElementById('priceMax').value = '';
        
        // Show all cards
        flightCards.forEach(card => {
            card.style.display = 'block';
        });
        
        // Hide no results message
        noResultsMessage.classList.add('hidden');
        flightContainer.classList.remove('hidden');
    });
});
</script>

<style>
    .flight-schedule-container {
        font-family: 'Inter', sans-serif;
    }
    
    .filter-group {
        transition: all 0.2s ease;
    }
    
    .filter-group:hover {
        transform: translateY(-2px);
    }
    
    /* Floating animation for the airplane icon */
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    /* Fade in up animation for flight cards */
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
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
    
    /* Pulse animation for the flight path arrow */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
