<?php
include '../connect_db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM venues WHERE idvenues = ?");
    $stmt->execute([$id]);
    $venue = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("
        SELECT rs.*, r_status.category 
        FROM reservation_slots rs
        INNER JOIN reservation_status r_status ON rs.status = r_status.idreservation_status
        WHERE rs.venue = ? AND rs.date >= CURDATE()
        ORDER BY rs.date, rs.time_start
    ");
    $stmt2->execute([$id]);
    $reservations = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['error']) && $_GET['error'] === 'conflict') {
    echo '<div class="fixed p-3 text-center text-red-600 transform -translate-x-1/2 bg-red-100 border border-red-500 rounded shadow-md top-10 left-1/2">
            <strong>Error:</strong> Time conflict. Please choose a different time.
        </div>';

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve - <?= $venue['name'] ?></title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="../assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome/fontawesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>
    <style>
        <style>.noUi-handle {
            transition: opacity 0.2s ease-in-out;
        }

        .noUi-handle-active {
            opacity: 1 !important;
        }

        .noUi-tooltip {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .noUi-tooltip.active {
            opacity: 1 !important;
        }

        .noUi-connect {
            background-color: #FFA500;
        }

        .noUi-base {
            background-color: #e0e0e0;
        }

        #loading-overlay {
            z-index: 50;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #FFA500;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    </style>
</head>

<body class="text-gray-900 bg-gray-50">
    <?php include("layout/nav.php") ?>


    <div class="max-w-screen-md p-4 mx-auto">


        <div id="main-content" class="mb-6">
            <?php if (!empty($venue['image'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($venue['image']) ?>" alt="Image of <?= $venue['name'] ?>"
                    class="object-cover w-full h-64 rounded-lg shadow-md">
            <?php else: ?>
                <div class="flex items-center justify-center w-full h-64 bg-gray-300 rounded-lg shadow-md">
                    <span class="text-lg text-gray-500">No image available</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h1 class="mb-10 text-2xl font-bold text-center text-orange-500 md:text-4xl">
                <?= $venue['name'] ?>
            </h1>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Description</h2>
                <button id="book-now-btn"
                    class="px-4 py-2 text-sm font-bold text-white bg-orange-500 rounded hover:bg-orange-600">Book
                    Now</button>
            </div>
            <p class="mb-6 text-gray-700">
                <?= $venue['description'] ?>
            </p>

            <div class="mb-6">
                <span class="font-medium text-gray-600">Capacity:</span>
                <span class="text-gray-800"><?= $venue['capacity_pax'] ?> pax</span>
            </div>

            <div class="mb-6">
                <h2 class="mb-2 text-lg font-semibold text-gray-800">Available Time</h2>
                <div class="flex items-center justify-between">
                    <div class="flex flex-col items-center">
                        <span class="text-sm text-gray-600">Start Time</span>
                        <span
                            class="text-xl font-bold text-orange-500"><?= date('g:i A', strtotime($venue['min_time'])) ?></span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-sm text-gray-600">End Time</span>
                        <span
                            class="text-xl font-bold text-orange-500"><?= date('g:i A', strtotime($venue['max_time'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Upcoming Events</h2>
            <?php if (count($reservations) > 0): ?>
                <ul class="space-y-4">
                    <?php foreach ($reservations as $reservation): ?>
                        <li class="p-4 rounded-lg shadow bg-gray-50">
                            <p class="text-xl font-semibold "><?= ucfirst($reservation['event']) ?></p>
                            <p class="text-sm text-gray-600"><?= date('F j, Y', strtotime($reservation['date'])) ?></p>
                            <p class="font-semibold text-orange-500">
                                <?= date('g:i A', strtotime($reservation['time_start'])) ?> -
                                <?= date('g:i A', strtotime($reservation['time_end'])) ?>
                            </p>
                            <!-- <p class="text-gray-700">Status: <?= $reservation['category'] ?></p> -->
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-500">No upcoming events for this venue.</p>
            <?php endif; ?>
        </div>

        <div id="booking-modal"
            class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50 modal">
            <div class="relative p-6 m-10 bg-white rounded-lg shadow-lg md:m-0 w-96">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">Book Reservation</h2>
                <form id="booking-form" method="POST" action="logic/add_reservation.php">
                    <input type="hidden" name="venue_id" value="<?= $id ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Event</label>
                        <input type="text" id="event" name="event" class="w-full p-2 mt-1 border rounded"
                            placeholder="max. 90 characters" required />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Select Date</label>
                        <input type="date" id="date-picker" name="date" class="w-full p-2 mt-1 border rounded" required
                            min="<?= date('Y-m-d') ?>" />

                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Select Time Range</label>
                        <div id="time-range-slider" class="w-full mt-4"></div>
                        <div class="flex justify-between mt-2 text-sm">
                            <span id="start-time-display" class="text-gray-700"></span>
                            <span id="end-time-display" class="text-gray-700"></span>
                        </div>
                        <input type="hidden" id="start-time-input" name="start_time">
                        <input type="hidden" id="end-time-input" name="end_time">
                    </div>

                    <div class="flex justify-between">
                        <button type="button" id="close-modal"
                            class="px-4 py-2 text-sm font-bold text-gray-600 border rounded hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-bold text-white bg-orange-500 rounded hover:bg-orange-600">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="loading-overlay" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="loader"></div>
        </div>

    </div>
</body>

<script src="layout/nav.js"></script>
<script>
    $(document).ready(function () {
        const minTime = "<?= $venue['min_time'] ?>";
        const maxTime = "<?= $venue['max_time'] ?>";
        const timeSteps = [];

        const timeFormatter = new Intl.DateTimeFormat('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });

        function generateTimeSteps() {
            let startTime = new Date(`1970-01-01T${minTime}`);
            const endTime = new Date(`1970-01-01T${maxTime}`);
            while (startTime <= endTime) {
                timeSteps.push({
                    value: timeSteps.length,
                    time: new Date(startTime),
                    label: timeFormatter.format(startTime)
                });
                startTime.setMinutes(startTime.getMinutes() + 30); // Increment by 30 minutes
            }
        }

        generateTimeSteps();

        const slider = document.getElementById("time-range-slider");

        noUiSlider.create(slider, {
            start: [0, timeSteps.length - 1],
            connect: true,
            step: 1,
            range: {
                min: 0,
                max: timeSteps.length - 1
            },
            tooltips: false, // Disable tooltips
            format: {
                to: function (value) {
                    return Math.round(value);
                },
                from: function (value) {
                    return Math.round(value);
                }
            }
        });

        slider.setAttribute("disabled", true); // Disable the slider initially

        $("#date-picker").on("change", function () {
            const selectedDate = $(this).val();
            if (selectedDate) {
                slider.removeAttribute("disabled");
            } else {
                slider.setAttribute("disabled", true);
            }
        });

        slider.noUiSlider.on("update", function (values, handle) {
            const startIndex = Math.round(values[0]);
            const endIndex = Math.round(values[1]);

            $("#start-time-display").text(timeSteps[startIndex].label);
            $("#end-time-display").text(timeSteps[endIndex].label);

            $("#start-time-input").val(timeSteps[startIndex].time.toISOString().slice(11, 16));
            $("#end-time-input").val(timeSteps[endIndex].time.toISOString().slice(11, 16));
        });

        $("#booking-modal").click(function (e) {
            if (e.target === this) {
                $(this).addClass("hidden");
            }
        });

        $("#book-now-btn").click(function () {
            $("#booking-modal").removeClass("hidden");
        });

        $("#close-modal").click(function () {
            $("#booking-modal").addClass("hidden");
        });

        $("#booking-form").submit(function (e) {
            $("#loading-overlay").removeClass("hidden");
        });
    });


</script>

</html>