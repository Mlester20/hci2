<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header" style="padding-left:20px">
                <!-- Hamburger Icon for Mobile -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Navbar Brand (Visible on all devices) -->
                <a href="faculty_home.php" class="navbar-brand">
                    Scheduling System
                </a>
            </div>

            <!-- Navbar Right Menu (Collapsible on mobile) -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="faculty_home.php" style="color:#fff;">
                            <i class="glyphicon glyphicon-star-empty text-red"></i> Class Schedule
                        </a>
                    </li>

                    <!-- <li>
                        <a href="faculty_exam1.php" style="color:#fff;">
                            <i class="glyphicon glyphicon-th text-red"></i> Exam Schedule
                        </a>
                    </li> -->

                    <li>
                        <a href="profile.php?showModal=true" class="dropdown-toggle">
                            <i class="glyphicon glyphicon-user text-orange"></i>
                            <?php echo $_SESSION['name']; ?>
                        </a>
                    </li>

                    <li>
                        <a href="logout.php" class="dropdown-toggle"
                            onclick="return confirm('Are you sure you want to logout?')">
                            <i class="glyphicon glyphicon-off text-red"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>

<!-- Add Bootstrap 3 and jQuery scripts (necessary for the navbar toggle) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>