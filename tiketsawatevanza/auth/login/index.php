<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TIKET!NG</title>
    <!-- Add Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('../../assets/images/pesawat.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: all 0.3s ease;
        }
        .input-field:focus + .input-icon {
            color: #3b82f6;
        }
        .input-field {
            padding-left: 3rem;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="font-sans">
    <div class="flex justify-center items-center min-h-screen p-4">
        <div class="card p-8 w-full max-w-md mx-4">
            <!-- Logo with subtle animation -->
            <div class="flex justify-center mb-6">
                <div class="bg-blue-500/90 p-3 rounded-xl transform hover:-translate-y-1 transition-transform duration-300 shadow-md">
                    <i class="fas fa-ticket-alt text-white text-2xl"></i>
                </div>
            </div>
            
            <h3 class="text-3xl font-bold text-center text-gray-800 mb-1">TIKET!NG</h3>
            <p class="text-center text-gray-600 mb-8">Sign in to your account</p>

            <form action="process.php" method="POST">
                <!-- Username -->
                <div class="input-group">
                    <input type="text" name="username" id="username" 
                           class="w-full p-3 border border-gray-200/80 rounded-lg input-field focus:outline-none focus:ring-2 focus:ring-blue-300/80 focus:border-transparent" 
                           placeholder="Username" required>
                </div>

                <!-- Password -->
                <div class="input-group">

                    <input type="password" name="password" id="password" 
                           class="w-full p-3 border border-gray-200/80 rounded-lg input-field focus:outline-none focus:ring-2 focus:ring-blue-300/80 focus:border-transparent" 
                           placeholder="Password" required>
                </div>
                
                <!-- Remember me and Forgot password -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Forgot password?</a>
                    </div>
                </div>
                
                <!-- Login Button -->
                <button type="submit" name="login" 
                        class="w-full py-3 bg-blue-600/90 text-white font-semibold rounded-lg hover:bg-blue-700/90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign in
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="../register/" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Sign up
                </a>
            </div>
        </div>
    </div>
</body>
</html>