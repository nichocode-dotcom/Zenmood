<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenMood - @yield('title', 'Login')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html::-webkit-scrollbar, body::-webkit-scrollbar {
            display: none; 
        }
        html, body {
            -ms-overflow-style: none;  
            scrollbar-width: none;  
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    @yield('content')
</body>
</html>
