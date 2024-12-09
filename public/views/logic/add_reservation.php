<?php
include '../../connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_id = $_POST['venue_id'];
    $user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    try {
        // Convert start_time and end_time to DateTime objects and add 8 hours for adjustment
        $start_time_obj = new DateTime($start_time);
        $start_time_obj->modify('+8 hours');
        $adjusted_start_time = $start_time_obj->format('H:i:s');

        $end_time_obj = new DateTime($end_time);
        $end_time_obj->modify('+8 hours');
        $adjusted_end_time = $end_time_obj->format('H:i:s');

        // Check for time conflicts
        $conflict_sql = "SELECT COUNT(*) FROM reservation_slots 
                         WHERE venue = :venue AND date = :date 
                         AND (
                             (time_start < :end_time AND time_end > :start_time)
                         )";
        $conflict_stmt = $pdo->prepare($conflict_sql);
        $conflict_stmt->bindParam(':venue', $venue_id);
        $conflict_stmt->bindParam(':date', $date);
        $conflict_stmt->bindParam(':start_time', $adjusted_start_time);
        $conflict_stmt->bindParam(':end_time', $adjusted_end_time);
        $conflict_stmt->execute();
        $conflict_count = $conflict_stmt->fetchColumn();

        if ($conflict_count > 0) {
            header("Location: ../reserve.php?id=$venue_id&error=conflict");
            exit;
        }

        $sql = "INSERT INTO reservation_slots (venue, reservee, date, time_start, time_end) 
                VALUES (:venue, :user, :date, :time_start, :time_end)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':venue', $venue_id);
        $stmt->bindParam(':user', $user_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time_start', $adjusted_start_time);
        $stmt->bindParam(':time_end', $adjusted_end_time);
        $stmt->execute();

        header("Location: ../reserve.php?id=$venue_id");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
