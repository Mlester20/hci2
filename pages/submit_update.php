<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

if ($_POST) {
    include('../dist/includes/dbcon.php');

    // Sanitize input data
    $sched_id = mysqli_real_escape_string($con, $_POST['id']);
    $member = mysqli_real_escape_string($con, $_POST['teacher']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $room = mysqli_real_escape_string($con, $_POST['room']);
    $cys = mysqli_real_escape_string($con, $_POST['cys']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);

    // Array of days for schedule times
    $days = [
        'm' => $_POST['m'] ?? [],
        't' => $_POST['t'] ?? [],
        'w' => $_POST['w'] ?? [],
        'th' => $_POST['th'] ?? [],
        'f' => $_POST['f'] ?? []
    ];

    // Prepare to track conflicts and successful updates
    $conflicts = [];
    $successful_updates = [];
    $errors = [];

    // Track if any day/time is selected
    $time_selected = false;

    // Loop through each day
    foreach ($days as $dayCode => $dayTimes) {
        // If no times selected for this day, skip
        if (!is_array($dayTimes) || empty($dayTimes)) continue;

        $time_selected = true;

        foreach ($dayTimes as $timeId) {
            // Escape timeId to prevent SQL injection
            $timeId = mysqli_real_escape_string($con, $timeId);

            // Comprehensive conflict check query
            $conflict_query = "
                SELECT 
                    m.member_last,
                    m.member_first,
                    t.time_start,
                    t.time_end,
                    s.sched_id,
                    'member' AS conflict_type
                FROM 
                    schedule s
                JOIN 
                    member m ON s.member_id = m.member_id
                JOIN 
                    time t ON s.time_id = t.time_id
                WHERE 
                    (s.member_id = '$member' OR s.room = '$room' OR s.cys = '$cys')
                    AND s.day = '$dayCode'
                    AND s.time_id = '$timeId'
                    AND s.sched_id != '$sched_id'
                
                UNION
                
                SELECT 
                    room AS member_last,
                    '' AS member_first,
                    t.time_start,
                    t.time_end,
                    s.sched_id,
                    'room' AS conflict_type
                FROM 
                    schedule s
                JOIN 
                    time t ON s.time_id = t.time_id
                WHERE 
                    s.room = '$room'
                    AND s.day = '$dayCode'
                    AND s.time_id = '$timeId'
                    AND s.sched_id != '$sched_id'
                
                UNION
                
                SELECT 
                    cys AS member_last,
                    '' AS member_first,
                    t.time_start,
                    t.time_end,
                    s.sched_id,
                    'class' AS conflict_type
                FROM 
                    schedule s
                JOIN 
                    time t ON s.time_id = t.time_id
                WHERE 
                    s.cys = '$cys'
                    AND s.day = '$dayCode'
                    AND s.time_id = '$timeId'
                    AND s.sched_id != '$sched_id'
            ";

            $conflict_result = mysqli_query($con, $conflict_query);
            
            // Check if there are any conflicts
            if (mysqli_num_rows($conflict_result) > 0) {
                $conflict_details = [];
                while ($conflict = mysqli_fetch_assoc($conflict_result)) {
                    $conflict_details[] = [
                        'day' => strtoupper($dayCode),
                        'time' => date("h:i a", strtotime($conflict['time_start'])) . "-" . date("h:i a", strtotime($conflict['time_end'])),
                        'conflicting_entity' => $conflict['member_last'] . 
                            (!empty($conflict['member_first']) ? " " . $conflict['member_first'] : ''),
                        'type' => $conflict['conflict_type']
                    ];
                }
                
                $conflicts[$dayCode][$timeId] = $conflict_details;
                continue; // Skip update if conflicts exist
            }

            // If no conflicts, update the schedule
            $update_query = "UPDATE schedule SET 
                time_id = '$timeId', 
                day = '$dayCode', 
                member_id = '$member', 
                subject_code = '$subject', 
                cys = '$cys', 
                room = '$room', 
                remarks = '$remarks'
                WHERE sched_id = '$sched_id'";

            if (mysqli_query($con, $update_query)) {
                $successful_updates[] = [
                    'day' => strtoupper($dayCode),
                    'time_id' => $timeId
                ];
            } else {
                $errors[] = "Error updating record for " . strtoupper($dayCode) . ": " . mysqli_error($con);
            }
        }
    }

    // Check if no day/time was selected
    if (!$time_selected) {
        $errors[] = "No time slot selected for the schedule.";
    }

    // Prepare response
    $response = [
        'successful_updates' => $successful_updates,
        'conflicts' => $conflicts,
        'errors' => $errors
    ];

    // Send back JSON response
    echo json_encode($response);
    exit();
} else {
    echo json_encode(['error' => 'No data submitted.']);
    exit();
}