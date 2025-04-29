<?php

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
    alert('Silahkan login terlebih dahulu');
    window.location ='../auth/login/';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Dashboard Admin</title>
</head>
<body class="flex">
    <!-- Sidebar -->
    <div class="bg-blue-600 shadow-md h-screen w-64 p-4 text-white">
    <div class="text-2xl font-bold mb-4">TIKET<span class="text-yellow-400">!NG</span></div>
    <nav class="font-semibold">
            <a href="/admin/index.php" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Dashboard") echo "bg-blue-700 text-white" ?>">Dashboard</a>
            <a href="/admin/pengguna/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Data Pengguna") echo "bg-blue-700 text-white" ?>">Data Pengguna</a>
            <a href="/admin/maskapai/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Maskapai") echo "bg-blue-700 text-white" ?>">Data Maskapai</a>
            <a href="/admin/kota/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Kota") echo "bg-blue-700 text-white" ?>">Data Kota</a>
            <a href="/admin/rute/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Rute") echo "bg-blue-700 text-white" ?>">Data Rute</a>
            <a href="/admin/jadwal/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Jadwal") echo "bg-blue-700 text-white" ?>">Data Jadwal Penerbangan</a>
            <a href="/admin/order/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Tiket") echo "bg-blue-700 text-white" ?>">Pemesanan Tiket</a>
            <a href="/logout.php" class="block py-2 px-4 rounded hover:bg-red-500 hover:text-white" onClick="return confirm('Apakah anda yakin ingin logout?')">Logout</a>
        </nav>
    </div>

</body>
</html>

