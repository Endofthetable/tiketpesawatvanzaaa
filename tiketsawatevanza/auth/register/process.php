<?php
require '../../koneksi.php'; // Include your database connection file

if (isset($_POST['register'])) {
    $nama_lengkap = $_POST["nama_lengkap"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username already exists
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        echo "
        <script type='text/javascript'>
            alert('Username sudah terdaftar!');
            window.location = 'register.php'; // Redirect back to the registration page
        </script>
        ";
    } else {
        // Insert new user into the database
        
        $insert_query = mysqli_query($conn, "INSERT INTO user (username, nama_lengkap, password, roles) VALUES ('$username', '$nama_lengkap', '$password', 'Penumpang')");

        if ($insert_query) {
            echo "
            <script type='text/javascript'>
                alert('Registrasi berhasil! Silakan login.');
                window.location = '../login/index.php' // Redirect to login page
            </script>
            ";
        } else {
            echo "
            <script type='text/javascript'>
                alert('Registrasi gagal! Silakan coba lagi.');
                window.location = 'index.php'; // Redirect back to the registration page
            </script>
            ";
        }
    }
}
?>