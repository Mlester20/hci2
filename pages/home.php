<?php
    session_start();
    if (empty($_SESSION['id'])) {
        header('Location:../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home | <?php include('../dist/includes/title.php'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSS includes -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
</head>

<body class="hold-transition skin-green layout-top-nav">
    <div class="wrapper">
        <?php include('../dist/includes/header.php'); ?>
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <!-- Schedule Selection -->
                        <div class="col-md-9">
                            <div class="box box-warning text-center">
                                <h4 class="card-title">Print Class Schedule
                                    <!-- <a href="#searcht" data-target="#searcht" data-toggle="modal"
                                        class="dropdown-toggle btn btn-primary">
                                        Professor | Instructor
                                    </a> -->
                                    <a href="#searchclass" data-target="#searchclass" data-toggle="modal"
                                        class="dropdown-toggle btn btn-success">
                                        Class
                                    </a>
                                    <!-- <a href="#searchroom" data-target="#searchroom" data-toggle="modal"
                                        class="dropdown-toggle btn btn-warning">
                                        Room
                                    </a> -->
                                </h4>
                                <!-- <h4 class="flex text-center card-title">Create Class Schedule</h4> -->
                                <form method="post" id="reg-form">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6" style="width: 100%;">
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Time</th>
                                                            <th class="text-center">M</th>
                                                            <th class="text-center">T</th>
                                                            <th class="text-center">W</th>
                                                            <th class="text-center">TH</th>
                                                            <th class="text-center">F</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include('../dist/includes/dbcon.php');
                                                        $query = mysqli_query($con, "SELECT * FROM time WHERE days='mtwthf' ORDER BY time_start") or die(mysqli_error($con));
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id = $row['time_id'];
                                                            $start = date("h:i a", strtotime($row['time_start']));
                                                            $end = date("h:i a", strtotime($row['time_end']));
                                                        ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $start . " - " . $end; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" id="check_m_<?php echo $id; ?>"
                                                                        name="m[]" value="<?php echo $id; ?>"
                                                                        style="width: 20px; height: 20px;"
                                                                        onchange="toggleCheckbox('check_t_<?php echo $id; ?>', this.checked)">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" id="check_t_<?php echo $id; ?>"
                                                                        name="t[]" value="<?php echo $id; ?>"
                                                                        style="width: 20px; height: 20px;"
                                                                        onchange="toggleCheckbox('check_w_<?php echo $id; ?>', this.checked)">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" id="check_w_<?php echo $id; ?>"
                                                                        name="w[]" value="<?php echo $id; ?>"
                                                                        style="width: 20px; height: 20px;"
                                                                        onchange="toggleCheckbox('check_th_<?php echo $id; ?>', this.checked)">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" id="check_th_<?php echo $id; ?>"
                                                                        name="th[]" value="<?php echo $id; ?>"
                                                                        style="width: 20px; height: 20px;"
                                                                        onchange="toggleCheckbox('check_f_<?php echo $id; ?>', this.checked)">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" id="check_f_<?php echo $id; ?>"
                                                                        name="f[]" value="<?php echo $id; ?>"
                                                                        style="width: 20px; height: 20px;"
                                                                        onchange="toggleCheckbox(null, this.checked)">
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Display Result Messages Here -->
                                        <div class="result"></div>
                                    </div>
                            </div>
                        </div>
                        <!-- Schedule Details Form -->
                        <div class="col-md-3">
                            <div class="box box-warning">
                                <div class="box-body">
                                    <div id="form1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Professor Selection -->
                                                <div class="form-group">
                                                    <label for="teacher">Professor | Instructor</label>
                                                    <select class="form-control select2" name="teacher" id="teacher"
                                                        required>
                                                        <?php
                                                        $query2 = mysqli_query($con, "SELECT * FROM member ORDER BY member_last") or die(mysqli_error($con));
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                        ?>
                                                            <option value="<?php echo $row['member_id']; ?>">
                                                                <?php echo $row['member_last'] . ", " . $row['member_first']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!-- Subject Selection -->
                                                <div class="form-group">
                                                    <label for="subject">Subject</label>
                                                    <select class="form-control select2" name="subject" id="subject"
                                                        required>
                                                        <?php
                                                        $query2 = mysqli_query($con, "SELECT * FROM subject ORDER BY subject_code") or die(mysqli_error($con));
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                        ?>
                                                            <option><?php echo $row['subject_code']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!-- Course, Year & Section Selection -->
                                                <div class="form-group">
                                                    <label for="cys">Course, Yr & Section</label>
                                                    <select class="form-control select2" name="cys" id="cys" required>
                                                        <?php
                                                        $query2 = mysqli_query($con, "SELECT * FROM cys ORDER BY cys") or die(mysqli_error($con));
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                        ?>
                                                            <option><?php echo $row['cys']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!-- Room Selection -->
                                                <div class="form-group">
                                                    <label for="room">Room</label>
                                                    <select class="form-control select2" name="room" id="room" required>
                                                        <?php
                                                        $query2 = mysqli_query($con, "SELECT * FROM room ORDER BY room") or die(mysqli_error($con));
                                                        while ($row = mysqli_fetch_array($query2)) {
                                                        ?>
                                                            <option><?php echo $row['room']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!-- Remarks -->
                                                <div class="form-group">
                                                    <label for="type">Type (e.g. Lecture/Laboratory)</label><br>
                                                    <select name="remarks" id="type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="lecture">Lecture</option>
                                                        <option value="computer_laboratory">Computer Laboratory</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label for="remarks">Remarks</label><br>
                                                    <textarea name="remarks" id="remarks" cols="30" rows="3"
                                                        placeholder="Enclose remarks with parenthesis()"></textarea>
                                                </div> -->
                                            </div>
                                        </div>
                                        <!-- Form Buttons -->
                                        <div class="form-group">
                                            <button class="btn btn-lg btn-primary" type="submit">
                                                Save
                                            </button>
                                            <button class="uncheck btn btn-lg btn-success" type="reset">Uncheck
                                                All</button>
                                        </div>
                                    </div>
                                    <hr>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col (right) -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div><!-- /.container -->
        </div><!-- /.content-wrapper -->
        <?php include('../dist/includes/footer.php'); ?>
    </div><!-- ./wrapper -->
    <!-- Modals for Searching Schedules -->
    <!-- Search Faculty Schedule Modal -->
    <div id="searcht" class="modal fade" role="dialog" aria-labelledby="searchtLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="height:auto">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="searchtLabel">Search Faculty Schedule</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="faculty_sched.php" target="_blank">
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="faculty">Faculty</label>
                            <div class="col-lg-10">
                                <select class="select2" name="faculty" id="faculty" style="width:90%!important"
                                    required>
                                    <?php
                                    $query2 = mysqli_query($con, "SELECT * FROM member ORDER BY member_last") or die(mysqli_error($con));
                                    while ($row = mysqli_fetch_array($query2)) {
                                    ?>
                                        <option value="<?php echo $row['member_id']; ?>">
                                            <?php echo $row['member_last'] . ", " . $row['member_first']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" name="search" class="btn btn-primary">Display Schedule</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Search Class Schedule Modal -->
    <div id="searchclass" class="modal fade" role="dialog" aria-labelledby="searchclassLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="height:auto">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="searchclassLabel">Search Class Schedule</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="class_sched.php" target="_blank">
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="class">Class</label>
                            <div class="col-lg-10">
                                <select class="select2" name="class" id="class" style="width:90%!important" required>
                                    <?php
                                    $query2 = mysqli_query($con, "SELECT * FROM cys ORDER BY cys") or die(mysqli_error($con));
                                    while ($row = mysqli_fetch_array($query2)) {
                                    ?>
                                        <option><?php echo $row['cys']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" name="search" class="btn btn-primary">Display Schedule</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Search Room Schedule Modal -->
    <div id="searchroom" class="modal fade" role="dialog" aria-labelledby="searchroomLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="height:auto">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="searchroomLabel">Search Room Schedule</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="room_sched.php" target="_blank">
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="room_search">Room</label>
                            <div class="col-lg-10">
                                <select class="select2" name="room" id="room_search" style="width:90%!important"
                                    required>
                                    <?php
                                    $query2 = mysqli_query($con, "SELECT * FROM room ORDER BY room") or die(mysqli_error($con));
                                    while ($row = mysqli_fetch_array($query2)) {
                                    ?>
                                        <option><?php echo $row['room']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" name="search" class="btn btn-primary">Display Schedule</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- JavaScript includes -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/select2/select2.full.min.js"></script>
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/demo.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Custom scripts -->
    <script src="./../control.js"></script>
    <script src="./../submit.js"></script>
</body>

</html>