<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

if ($_POST) {
    include('../dist/includes/dbcon.php');

    $member = $_POST['teacher'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $room = $_POST['room'] ?? null;
    $cys = $_POST['cys'] ?? null;
    $remarks = $_POST['remarks'] ?? null;

    // Use null coalescing operator to avoid undefined index notices
    $m = $_POST['m'] ?? [];
    $t = $_POST['t'] ?? [];
    $w = $_POST['w'] ?? [];
    $th = $_POST['th'] ?? [];
    $f = $_POST['f'] ?? [];

    $set_id = $_SESSION['settings'];
    $program = $_SESSION['id'];

    // Array of days for looping through each schedule
    $days = [
        'm' => $m,
        't' => $t,
        'w' => $w,
        'th' => $th,
        'f' => $f
    ];

    // Loop through each day
    foreach ($days as $dayCode => $dayTimes) {
        // Ensure $dayTimes is an array before iterating
        if (is_array($dayTimes)) {
            foreach ($dayTimes as $timeId) {
                // Check for member conflicts
                $query_member = mysqli_query($con, "SELECT *, COUNT(*) as count FROM schedule 
                                                    NATURAL JOIN member NATURAL JOIN time 
                                                    WHERE member_id='$member' AND schedule.time_id='$timeId' AND day='$dayCode'");
                $row_member = mysqli_fetch_array($query_member);
                $count_member = $row_member['count'] ?? 0; // Safe access
                $time_member = isset($row_member['time_start']) && isset($row_member['time_end']) ? date("h:i a", strtotime($row_member['time_start'])) . "-" . date("h:i a", strtotime($row_member['time_end'])) : 'N/A';
                $member_name = $row_member['member_last'] . ", " . $row_member['member_first'] ?? 'Unknown';

                $error_member = "<span class='text-danger'>
                                <table width='100%'>
                                    <tr>
                                        <td>" . ucfirst($dayCode) . "</td>
                                        <td>$time_member</td>
                                        <td>$member_name</td>
                                        <td><b>Conflict</b></td>
                                    </tr>
                                </table></span>";

                // Check for room conflicts
                $query_room = mysqli_query($con, "SELECT *, COUNT(*) as count FROM schedule 
                                                  NATURAL JOIN member NATURAL JOIN time 
                                                  WHERE room='$room' AND schedule.time_id='$timeId' AND day='$dayCode'");
                $row_room = mysqli_fetch_array($query_room);
                $count_room = $row_room['count'] ?? 0; // Safe access
                $time_room = isset($row_room['time_start']) && isset($row_room['time_end']) ? date("h:i a", strtotime($row_room['time_start'])) . "-" . date("h:i a", strtotime($row_room['time_end'])) : 'N/A';
                $room_name = $row_room['room'] ?? 'Unknown';

                $error_room = "<span class='text-danger'>
                                <table width='100%'>
                                    <tr>
                                        <td>" . ucfirst($dayCode) . "</td>
                                        <td>$time_room</td>
                                        <td>Room $room_name</td>
                                        <td><b>Conflict</b></td>
                                    </tr>
                                </table></span>";

                // Check for class conflicts
                $query_class = mysqli_query($con, "SELECT *, COUNT(*) as count FROM schedule 
                                                   NATURAL JOIN member NATURAL JOIN time 
                                                   WHERE cys='$cys' AND schedule.time_id='$timeId' AND day='$dayCode'");
                $row_class = mysqli_fetch_array($query_class);
                $count_class = $row_class['count'] ?? 0; // Safe access
                $time_class = isset($row_class['time_start']) && isset($row_class['time_end']) ? date("h:i a", strtotime($row_class['time_start'])) . "-" . date("h:i a", strtotime($row_class['time_end'])) : 'N/A';
                $class_name = $row_class['cys'] ?? 'Unknown';

                $error_class = "<span class='text-danger'>
                                <table width='100%'>
                                    <tr>
                                        <td>" . ucfirst($dayCode) . "</td>
                                        <td>$time_class</td>
                                        <td>$class_name</td>
                                        <td><b>Conflict</b></td>
                                    </tr>
                                </table></span>";

                // Determine if the schedule can be inserted
                if ($count_member == 0 && $count_room == 0 && $count_class == 0) {
                    $query_insert = "INSERT INTO schedule(time_id, day, member_id, subject_code, cys, room, remarks, settings_id, encoded_by) 
                                    VALUES('$timeId', '$dayCode', '$member', '$subject', '$cys', '$room', '$remarks', '$set_id', '$program')";
                    if (mysqli_query($con, $query_insert)) {
                        echo "<span class='text-success'>
                              <table width='100%'>
                                  <tr>
                                      <td>" . ucfirst($dayCode) . "</td>
                                      <td>$time_class</td>
                                      <td>Success</td>
                                  </tr>
                              </table></span><br>";
                    } else {
                        echo "<span class='text-danger'>Error inserting record: " . mysqli_error($con) . "</span><br>";
                    }
                } else {
                    // Output appropriate error if conflicts exist
                    if ($count_member > 0) echo $error_member . "<br>";
                    if ($count_room > 0) echo $error_room . "<br>";
                    if ($count_class > 0) echo $error_class . "<br>";
                }
            }
        }
    }
} else {
    echo "<span class='text-danger'>No data submitted.</span>";
}
