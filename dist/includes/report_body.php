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
	$query = mysqli_query($con, "SELECT * FROM time WHERE days='mtwthf' ORDER BY time_start") or die(mysqli_error($con));

	while ($row = mysqli_fetch_array($query)) {
		$id = $row['time_id'];
		$start = date("h:i a", strtotime($row['time_start']));
		$end = date("h:i a", strtotime($row['time_end']));
	?>
    <tr>
        <td class="first"><?php echo $start . "-" . $end; ?></td>
        <?php
			$days = ['m', 't', 'w', 'th', 'f'];
			foreach ($days as $day) {
				echo "<td>";
				$query1 = null;

				if ($member != "") {
					$query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.member_id='$member' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
				} elseif ($room != "") {
					$query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.room='$room' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
				} elseif ($class != "") {
					$query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.cys='$class' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
				}

				if ($query1) {
					$row1 = mysqli_fetch_array($query1);
					$count = mysqli_num_rows($query1);

					if ($count > 0) {
						$id1 = $row1['sched_id'];
						$encode = $row1['encoded_by'];
						$mid = $_SESSION['id'];
						$remarks = !empty($row1['remarks']) ? "<li>$row1[remarks]</li>" : "";
						$options = $mid == $encode ? "" : "none";

						echo "<div class='show'>";
						echo "<ul>
                                <li class='options' style='display:$options'>
                                    <span style='float:left;'><a href='sched_edit.php?id=$id1' class='edit' title='Edit'>Edit</a></span>
                                    <span class='action'><a href='#' id='$id1' class='delete' title='Delete'>Remove</a></span>
                                </li>";

						echo "<li class='showme'>{$row1['subject_code']}</li>";
						echo "<li class='$displayc'>{$row1['cys']}</li>";
						echo "<li class='$displaym'>{$row1['member_last']}, {$row1['member_first']}</li>";
						echo "<li class='$displayr'>Room {$row1['room']}</li>";
						echo $remarks;
						echo "</ul></div>";
					}
				}
				echo "</td>";
			}
			?>
    </tr>
    <?php } ?>
</table>