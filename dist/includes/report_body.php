<style>
	table {
		width: 100%;
		border-collapse: collapse;
		font-family: Arial, sans-serif;
		margin-top: 20px;
	}

	th,
	td {
		padding: 10px 15px;
		text-align: center;
		font-size: 14px;
		border: 1px solid #ddd;
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
	}
</style>

<table style="width:100%;float:left">
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
	?>
		<tr>
			<td class="first"><?php echo $start . " - " . $end; ?></td>

		<?php
		// Days array to map days of the week
		$days = ['m', 't', 'w', 'th', 'f'];

		// Loop through each day (monday to friday)
		foreach ($days as $day) {
			echo "<td>";

			// Query to check if there's a scheduled class for the day, time, and other filters (e.g. member, room, class)
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
					$remarks = !empty($row1['remarks']) ? "<li>$row1[remarks]</li>" : "";
					$options = $mid == $encode ? "" : "none"; // Show edit/delete options if it's the current user's schedule

					echo "<div class='show'>";
					echo "<ul>
                                <li class='options' style='display:$options'>
                                    <span style='float:left;'><a href='sched_edit.php?id=$id1' class='edit' title='Edit'>Edit</a></span>
                                    <span class='action'><a href='#' id='$id1' class='delete' title='Delete'>Remove</a></span>
                                </li>";
					echo "<li class='showme'>{$row1['subject_code']}</li>";
					echo "<li class='showc'>{$row1['cys']}</li>";
					echo "<li class='showm'>{$row1['member_last']}, {$row1['member_first']}</li>";
					echo "<li class='showr'>Room {$row1['room']}</li>";
					echo $remarks;
					echo "</ul></div>";
				}
			}
			echo "</td>"; // Close the cell
		}

		// Only show the row if at least one day has a scheduled class
		if ($hasSchedule) {
			echo "</tr>"; // Close the row
		}
	}
		?>
</table>