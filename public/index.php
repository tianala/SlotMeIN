<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error_message = isset($_SESSION["error_message"]) ? $_SESSION["error_message"] : [];

include_once "connect_db.php";

if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true) {
        header('location: ./views/dashboard.php');
    }
}
$stmt = $pdo->prepare("SELECT idorganizations as idorg, name from organizations");
$stmt->execute();
$orgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>

#dropdown::-webkit-scrollbar-button {
    display: none !important;
}

#dropdown {
    scrollbar-width: thin;
    scrollbar-color: #ff8c42 transparent;
}

#dropdown::-webkit-scrollbar {
    width: 5px;
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/output.css" rel="stylesheet">
    <link href="assets/css/fontawesome/all.min.css" rel="stylesheet" >
    <link href="assets/css/fontawesome/fontawesome.min.css" rel="stylesheet">
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <title>Sign In</title>
</head>
<body class="flex w-screen min-h-screen bg-zinc-700">
    <?php if($error_message): ?>
        <div id="errorMessage" class="fixed z-20 px-4 py-2 text-orange-500 transform -translate-x-1/2 bg-white rounded-lg shadow top-10 left-1/2">
            <?= htmlspecialchars($error_message)?>
        </div>
        <?php unset($_SESSION["error_message"]);?>
    <?php endif; ?>

    <div class="flex flex-col w-full h-screen md:h-3/4 md:m-auto md:bg-transparent bg-zinc-700">
        <div class="flex items-center justify-center w-11/12 h-full p-5 mx-auto md:w-1/2">
            <div class="flex flex-col w-full p-4 bg-white shadow md:w-1/2 md:min-w-[30rem] rounded-xl h-[32rem] md:h-[37rem]">

            <!-- Log in -->
                <div id="logInDiv" class="w-full h-full">
                    <img class="w-40 h-40 m-auto md:mb-5 md:w-60 md:h-60 " src="assets/images/logo.png">
                    <form id="logInForm" action="views/logic/sign_in.php" type="button" method="POST" class="flex flex-col items-center w-full mt-5 h-fit">
                        <div class="flex items-center w-full p-2 mb-4 border border-gray-400 rounded-full md:w-5/6">
                            <i class="mx-2 text-xl text-gray-600 fa-regular fa-envelope"></i>
                            <input id="email" name="email" type="email" class="w-10/12 h-full px-1 text-lg focus:outline-none" placeholder="Enter your email" required>
                        </div>
        
                        <div class="flex items-center w-full p-2 border border-gray-400 rounded-full md:w-5/6">
                            <i class="mx-2 text-xl text-gray-600 fa-solid fa-lock"></i>
                            <div class="flex items-center w-full text-lg h-fit">
                                <input id="password" name="password" type="password" class="w-10/12 px-1 focus:outline-none h-fit" placeholder="Enter your password">
                                <i onclick="showPassword(this)" class="ml-5 fa-solid fa-eye"></i>
                            </div>
                        </div>
                        <div class="flex justify-end w-full h-10 p-1 mt-1 text-center text-black rounded-full"><a class="mr-12 text-orange-400 hover:underline" href="#">Forgot Password?</a></div>
                        <button id="logInBtn" type="submit"  class="w-40 h-10 p-1 mx-auto mt-8 text-xl font-semibold text-center text-white bg-orange-600 rounded-full hover:bg-orange-500">LOG IN</button>
                    </form>
                    <div class="h-10 p-1 mx-auto mt-8 text-center text-black rounded-full w-fit">Don't have an account? <a id="register" class="hover:text-orange-500 hover:underline" href="">Register</a></div>
                </div>

            <!-- Register -->
                <div id="registerDiv" class="hidden w-full h-full overflow-y-hidden">
                    <div class="flex justify-center w-full mt-4 text-4xl font-semibold text-orange-500 md:text-5xl">Sign Up</div>
                    <form id="registerForm" class="flex flex-col items-center w-full mt-10 md:mt-14" action="views/logic/register.php" method="POST">
                        <input id="first_name" name="first_name" class="w-10/12 pl-1 mb-3 text-lg border-b-2 border-gray-300 md:mb-5 focus:outline-b placeholder-zinc-700 focus:outline-none focus:border-orange-300" placeholder="First Name" required>
                        <input id="last_name" name="last_name" class="w-10/12 pl-1 mb-3 text-lg border-b-2 border-gray-300 md:mb-5 focus:outline-b placeholder-zinc-700 focus:outline-none focus:border-orange-300" placeholder="Last Name" required>
                        <input id="reg_email" type="email" name="reg_email" class="w-10/12 pl-1 mb-3 text-lg border-b-2 border-gray-300 md:mb-5 focus:outline-b placeholder-zinc-700 focus:outline-none focus:border-orange-300" placeholder="Email" required>
                        <input id="organization" name="organization" hidden>
                        <div id="organization_choice" class="relative flex items-center w-10/12 pl-1 mb-3 text-lg border-b-2 border-gray-300 cursor-default md:mb-5 focus:outline-b text-zinc-700 focus:outline-none focus:border-orange-300">
                            <div id="selected_org" class="w-4/5 overflow-x-hidden max-w-4/5 text-nowrap">Select your organization</div> 
                            <i id="dropdownBtn" onclick="toggleDropdown()" class="pl-2 ml-auto mr-2 cursor-pointer fa-solid fa-caret-down hover:text-orange-400"></i>
                            
                            <!-- Dropdown -->
                            <div id="dropdown" class="absolute z-10 flex-col invisible w-full mt-1 overflow-x-hidden overflow-y-auto bg-white border border-gray-300 rounded-md top-full h-36">
                                <?php foreach ($orgs as $org): ?>
                                    <div id="org-<?= $org["idorg"] ?>" data-id="<?= $org["idorg"] ?>" data-name="<?= $org["name"] ?>" onclick="selectOrganization(this)" class="w-full p-1 text-sm border-b cursor-pointer text-nowrap hover:bg-orange-100">
                                        <?= $org["name"] ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="flex items-center w-10/12 mb-3 border-b-2 border-gray-300 h-fit md:mb-5 focus:border-orange-300">
                            <input id="set_password" type="password" name="set_password" class="w-4/5 pl-1 text-lg placeholder-zinc-700 focus:outline-none" placeholder="Password" required>
                            <i onclick="showPassword(this)" class="ml-auto text-lg fa-solid fa-eye"></i>
                        </div>

                        <div class="flex items-center w-10/12 mb-3 border-b-2 border-gray-300 h-fit md:mb-5 focus:border-orange-300">
                            <input id="confirm_password" type="password" name="confirm_password" class="w-4/5 pl-1 text-lg placeholder-zinc-700 focus:outline-none" placeholder="Confirm password" required>
                            <i onclick="showPassword(this)" class="ml-auto text-lg fa-solid fa-eye"></i>
                        </div>                        
                        <button type="submit" class="px-3 py-2 mt-5 font-semibold text-white rounded-full bg-zinc-600 hover:bg-orange-400">Create your account</button>
                        <div class="h-10 p-1 mx-auto mt-5 text-center text-black rounded-full md:mt-8 w-fit">Already have an account? <a id="login" class="hover:text-orange-500 hover:underline" href="">Log in here</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="loaderDiv" class="fixed top-0 left-0 flex items-center justify-center invisible w-full h-full bg-gray-800/50 backdrop-blur-sm">
        <div class="w-12 h-12 border-4 border-orange-500 rounded-full border-t-transparent animate-spin"></div>
    </div>

    <!-- <style>
        .loader {
            @apply w-12 h-12 border-4 border-t-transparent border-blue-500 rounded-full animate-spin;
        }
    </style> -->
</body>


<script>
    function toggleDropdown() {
        $("#dropdown").toggleClass("invisible");
    }

    function selectOrganization(id) {
        $org_id = $(id).data("id");
        $org_name = $(id).data("name");

        $("#selected_org").text( $org_name);
        $("#organization").val($org_id);
        $("#dropdown").addClass("invisible");
    }

    function showPassword(e) {
        if ($(e).siblings('input').attr("type") === "password") {
            $(e).siblings('input').attr("type", "text");
            $(e).removeClass("fa-eye");
            $(e).addClass("fa-eye-slash");
        } else {
            $(e).siblings('input').attr("type", "password");
            $(e).removeClass("fa-eye-slash");
            $(e).addClass("fa-eye");
        }
    }

    function load() {
      $("#loaderDiv").removeClass("invisible"); 
      setTimeout(function () {
        location.reload();
      }, 2000);
    };

    $(document).ready(function () {
        $(document).ready(function () {
            setTimeout(function () {
                $("#errorMessage").fadeOut();
            }, 3000);
        });

        $("#register").on('click', function (event) {
            event.preventDefault();
            $("#logInDiv").addClass("hidden");
            $("#registerDiv").removeClass("hidden");
            $("#registerDiv").addClass("flex flex-col");
        }) 

        $("#login").on('click', function (event) {
            event.preventDefault();
            $("#registerDiv").addClass("hidden");
            $("#logInDiv").removeClass("hidden");
        }) 

        $(document).on('click', function (event) {
            if (!$(event.target).closest("#dropdown").length && !$(event.target).closest("#dropdownBtn").length) {
                $("#dropdown").addClass("invisible");
            }
        })

        $("#logInForm").on("submit", function (event) {
            email = $("#email").val();
            password = $("#password").val();

            if (!email || !password) {
                event.preventDefault();
                alert("Please fill in all fields.");
                return;
            }

            load();
        });

        $("#registerForm").on("submit", function (event) {
            password = $("#set_password").val();
            confirmPassword = $("#confirm_password").val();
            passwordRegex = /^(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/;

            if (!passwordRegex.test(password)) {
                event.preventDefault();
                alert("Password must be at least 8 characters long and contain at least one symbol.");
                return;
            }
            
            if (password !== confirmPassword) {
                event.preventDefault();
                alert("Passwords do not match. Please try again.");
            }

            if ($("#organization").val() === "") {
                event.preventDefault();
                alert("Please choose your organization.");
            }

            load();
        });
    })

</script>
</html>