<?php
session_start();
if (empty($_SESSION['id'])):
    header('Location:../index.php');
endif;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home | <?php include('../dist/includes/title.php'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <script src="../dist/js/jquery.min.js"></script>
</head>

<body class="hold-transition skin-green layout-top-nav" onload="myFunction()">
    <div class="wrapper">
        <?php include('../dist/includes/header_faculty.php'); ?>
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <form method="post" id="reg-form">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                        $member = $_SESSION['id'];
                                                        $sid = $_SESSION['settings'];
                                                        $query = mysqli_query($con, "SELECT * FROM time WHERE days='mtwthf' ORDER BY time_start") or die(mysqli_error($con));

                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id = $row['time_id'];
                                                            $start = date("h:i a", strtotime($row['time_start']));
                                                            $end = date("h:i a", strtotime($row['time_end']));

                                                            // Check if there's a schedule for any day in this time slot
                                                            $hasSchedule = false;
                                                            $days = ['m', 't', 'w', 'th', 'f'];
                                                            $schedules = [];

                                                            foreach ($days as $day) {
                                                                $query1 = mysqli_query($con, "SELECT * FROM schedule NATURAL JOIN member WHERE day='$day' AND schedule.member_id='$member' AND time_id='$id' AND settings_id='$sid'") or die(mysqli_error($con));
                                                                if ($row1 = mysqli_fetch_array($query1)) {
                                                                    $schedules[$day] = $row1['subject_code'] . "<br>" . $row1['cys'] . "<br>" . "Room " . $row1['room'] . "<br>" . $row1['remarks'];
                                                                    $hasSchedule = true; // Set to true if there's a schedule
                                                                } else {
                                                                    $schedules[$day] = ''; // Empty if no schedule
                                                                }
                                                            }

                                                            // Only display the row if there's at least one schedule for this time slot
                                                            if ($hasSchedule) {
                                                        ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $start . "-" . $end; ?>
                                                                    </td>
                                                                    <td><?php echo $schedules['m']; ?></td>
                                                                    <td><?php echo $schedules['t']; ?></td>
                                                                    <td><?php echo $schedules['w']; ?></td>
                                                                    <td><?php echo $schedules['th']; ?></td>
                                                                    <td><?php echo $schedules['f']; ?></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include('../dist/includes/footer.php'); ?>
    </div>

    <script>
        $(".uncheck").click(function() {
            $('input:checkbox').removeAttr('checked');
        });
    </script>

    <script type="text/javascript" src="autosum.js"></script>
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../dist/js/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/select2/select2.full.min.js"></script>
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/demo.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    <script>
        $(function() {
            $(".select2").select2();
            $("#datemask").inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            $("#datemask2").inputmask("mm/dd/yyyy", {
                "placeholder": "mm/dd/yyyy"
            });
            $("[data-mask]").inputmask();
            $('#reservation').daterangepicker();
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'MM/DD/YYYY h:mm A'
            });
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'));
                });
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
            $(".my-colorpicker1").colorpicker();
            $(".my-colorpicker2").colorpicker();
            $(".timepicker").timepicker({
                showInputs: false
            });
        });
    </script>
</body>

</html>