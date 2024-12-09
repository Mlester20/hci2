<style>
	table {
		width: 100%;
		border-collapse: collapse;
		font-family: Arial, sans-serif;
		margin-top: 10px;
		table-layout: fixed;
	}

	th, td {
		padding: 5px 5px;
		text-align: center;
		font-size: 10px;
		border: 1px solid #ddd;
		word-wrap: break-word;
	}

	th {
		background-color: #4CAF50;
		color: white;
		font-size: 16px;
	}

	tr:nth-child(even) {
		background-color: #f9f9f9;
	}

	tr:hover {
		background-color: #f1f1f1;
	}

	.first {
		font-weight: bold;
		text-align: left;
		width: 20%;
	}

	.col-monday {
		width: 15%;
	}

	.col-tuesday {
		width: 25%; 
	}

	.col-wednesday {
		width: 10%;
	}

	.col-thursday {
		width: 20%;
	}

	.col-friday {
		width: 10%;
	}
</style>

<table>
	<thead>
		<tr>
			<th class="first">Time</th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
		</tr>
	</thead>

	<?php
// Query to fetch time slots that have at least one class scheduled on any day
$query = mysqli_query($con, "
    SELECT DISTINCT time.*
    FROM time 
    LEFT JOIN schedule ON time.time_id = schedule.time_id
    WHERE schedule.day IN ('m', 't', 'w', 'th', 'f') 
    ORDER BY time.time_start
") or die(mysqli_error($con));

while ($row = mysqli_fetch_array($query)) {
    $id = $row['time_id'];
    $start = date("h:i a", strtotime($row['time_start']));
    $end = date("h:i a", strtotime($row['time_end']));

    // Initialize a flag to check if any schedule exists for this time slot
    $hasSchedule = false;

    // Buffer to hold row data
    $rowData = "<tr><td class='first'>" . $start . " - " . $end . "</td>";

    // Days array to map days of the week
    $days = ['m', 't', 'w', 'th', 'f'];

    // Loop through each day (Monday to Friday)
    foreach ($days as $day) {
        $rowData .= "<td>";

        // Query to check if there's a scheduled class for the day, time, and other filters (e.g., member, room, class)
        $query1 = null;

        if ($member != "") {
            // Filter by member
            $query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.member_id='$member' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
        } elseif ($room != "") {
            // Filter by room
            $query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.room='$room' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
        } elseif ($class != "") {
            // Filter by class
            $query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.cys='$class' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
        }

        // Check if there are results for the current query (schedule exists for this day and time)
        if ($query1) {
            $row1 = mysqli_fetch_array($query1);
            $count = mysqli_num_rows($query1);

            if ($count > 0) {
                // If there's a matching record, set the flag to true and display the schedule details
                $hasSchedule = true;
                $id1 = $row1['sched_id'];
                $encode = $row1['encoded_by'];
                $mid = $_SESSION['id'];
                $remarks = !empty($row1['remarks']) ? "<li>{$row1['remarks']}</li>" : "";
                $options = $mid == $encode ? "" : "none"; // Show edit/delete options if it's the current user's schedule

                $rowData .= "<div class='show'>";
                $rowData .= "<ul>
                                <li class='options' style='display:$options'>
                                    <span class='action'><a href='#' id='$id1' class='delete' title='Delete'>Remove</a></span>
                                </li>";
                $rowData .= "<li class='showme'>{$row1['subject_code']}</li>";
                $rowData .= "<li class='showc'>{$row1['cys']}</li>";
                $rowData .= "<li class='showm'>{$row1['member_last']}, {$row1['member_first']}</li>";
                $rowData .= "<li class='showr'>Room {$row1['room']}</li>";
                $rowData .= $remarks;
                $rowData .= "</ul></div>";
            }
        }
        $rowData .= "</td>"; // Close the cell
    }

    // Only show the row if at least one day has a scheduled class
    if ($hasSchedule) {
        echo $rowData . "</tr>"; // Close the row and output it
    }
}
?>

</table>