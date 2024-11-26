<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../assets/css/output.css" rel="stylesheet">
    <link href="../../../assets/css/fontawesome/all.min.css" rel="stylesheet" >
    <link href="../../../assets/css/fontawesome/fontawesome.min.css" rel="stylesheet">
    <script src="../../../assets/js/jquery-3.7.1.min.js"></script>
    <title>Sign In</title>
</head>
<body class="flex w-screen min-h-screen bg-gradient-to-tr from-[#ff8989] via-[#f8b9b9] to-white">
    <div class="flex flex-col w-full h-screen md:h-3/4 md:m-auto md:bg-transparent bg-[#f8b9b9]">
        <div class="flex items-center justify-center w-full h-1/3">
            <img class="w-40 h-40 mt-auto md:w-60 md:h-60" src="../../../assets/images/logo.png">
        </div>
        <div class="flex justify-center w-11/12 p-5 mx-auto md:w-1/2 h-3/5">
            <div class="flex flex-col w-full p-4 bg-white shadow md:w-1/2 md:min-w-[30rem] rounded-xl h-3/4 md:h-96">
                <forms class="flex flex-col items-center w-full mt-5 h-fit">
                    <div class="flex items-center w-full p-2 mb-4 border border-gray-400 rounded-full">
                        <i class="mx-2 text-xl text-gray-600 fa-regular fa-envelope"></i>
                        <input class="w-10/12 h-full px-1 text-lg focus:outline-none" type="text" placeholder="Enter your email">
                    </div>
    
                    <div class="flex items-center w-full p-2 border border-gray-400 rounded-full">
                        <i class="mx-2 text-xl text-gray-600 fa-solid fa-lock"></i>
                        <input class="w-10/12 h-full px-1 text-lg focus:outline-none" type="password" placeholder="Enter your password">
                    </div>
                </forms>
                <button class="w-40 h-10 p-1 mx-auto mt-10 text-xl font-semibold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600">LOG IN</button>
                <div class="w-40 h-10 p-1 mx-auto mt-4 text-xl font-semibold text-center text-gray-700 rounded-full"><a class="hover:text-[#ff8989]" href="register.php">REGISTER</a></div>
                <div class="w-40 h-10 p-1 mx-auto mt-5 text-center text-black rounded-full"><a class="hover:text-[#fc7474] hover:underline" href="###">Forgot password?</a></div>
            </div>
        </div>
    </div>
</body>
</html>