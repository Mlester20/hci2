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
    <title>Account Details | <?php include('../dist/includes/title.php'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script> <!-- jQuery -->
    <script src="../bootstrap/js/bootstrap.min.js"></script> <!-- Bootstrap -->

    <style>
        /* Apply blur effect only to the background content when modal is opened */
        .content-wrapper.blurred {
            filter: blur(5px);
            transition: filter 0.3s ease-in-out;
        }

        /* Smooth transition */
        body {
            transition: filter 0.3s ease-in-out;
        }
    </style>

    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('showModal') && urlParams.get('showModal') === 'true') {
                $('#accountModal').modal('show');
            }

            // Add blur effect to content-wrapper when modal is shown
            $('#accountModal').on('show.bs.modal', function() {
                $('.content-wrapper').addClass('blurred');
            });

            // Remove blur effect from content-wrapper when modal is hidden
            $('#accountModal').on('hidden.bs.modal', function() {
                $('.content-wrapper').removeClass('blurred');
            });
        });
    </script>
</head>

<body class="hold-transition skin-green layout-top-nav">
    <div class="wrapper">
        <?php include('../dist/includes/header.php');
        include('../dist/includes/dbcon.php');
        ?>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <!-- <h1>
                        <a class="btn btn-lg btn-warning" href="home.php">Back</a>
                    </h1> -->
                </section>

                <?php
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM member WHERE member_id='$id'") or die(mysqli_error($con));
                $row = mysqli_fetch_array($query);
                ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Modal -->
                            <div class="modal fade" id="accountModal" tabindex="-1" role="dialog"
                                aria-labelledby="accountModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="accountModalLabel">Update Account Details</h4>
                                        </div>
                                        <form method="post" action="profile_update.php">
                                            <div class="modal-body">
                                                <!-- Full Name -->
                                                <div class="form-group">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo $row['member_first'] . " " . $row['member_last']; ?>"
                                                        name="name" placeholder="Full Name" required>
                                                </div>

                                                <!-- Username -->
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo $row['username']; ?>" name="username"
                                                        placeholder="Username" required>
                                                </div>

                                                <!-- Change Password -->
                                                <div class="form-group">
                                                    <label for="password">Change Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Type new password">
                                                </div>

                                                <!-- Confirm New Password -->
                                                <div class="form-group">
                                                    <label for="new">Confirm New Password</label>
                                                    <input type="password" class="form-control" name="new"
                                                        placeholder="Confirm new password">
                                                </div>

                                                <!-- Old Password (to confirm changes) -->
                                                <div class="form-group">
                                                    <label for="passwordold">Enter Old Password to Confirm
                                                        Changes</label>
                                                    <input type="password" class="form-control" name="passwordold"
                                                        placeholder="Enter old password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                <?php
                                                // Check status from database
                                                $id = $_SESSION['id'];
                                                $query = mysqli_query($con, "SELECT status FROM member WHERE member_id='$id'") or die(mysqli_error($con));
                                                $row = mysqli_fetch_array($query);

                                                if ($row['status'] == 'admin') {
                                                    echo '<a href="home.php" class="btn btn-secondary">Cancel</a>';
                                                } else if ($row['status'] == 'user') {
                                                    echo '<a href="faculty_home.php" class="btn btn-secondary">Cancel</a>';
                                                }
                                                ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/demo.js"></script>
</body>

</html>