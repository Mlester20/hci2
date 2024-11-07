<style>
.navbar-toggle .fa-bars {
    color: black !important;
    /* Make the hamburger icon black */
}
</style>

<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header" style="padding-left:20px">
                <!-- Hamburger Icon for Mobile -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a href="home.php" class="navbar-brand">Scheduling</a>
            </div>

            <!-- Navbar Menu -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Class Schedule Menu -->
                    <li>
                        <a href="home.php" style="font-size:14px"><i class="glyphicon glyphicon-star-empty"></i> Class
                            Schedule</a>
                    </li>

                    <!-- Exam Schedule Menu -->
                    <li>
                        <a href="exam.php" style="font-size:14px"><i class="glyphicon glyphicon-list-alt"></i> Exam
                            Schedule</a>
                    </li>

                    <!-- Entry Dropdown Menu -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-file"></i> Entry <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="class.php"><i class="glyphicon glyphicon-user text-green"></i> Class</a></li>
                            <li><a href="room.php"><i class="glyphicon glyphicon-scale text-green"></i> Room</a></li>
                            <li><a href="subject.php"><i class="glyphicon glyphicon-user text-green"></i> Subject</a>
                            </li>
                            <li><a href="teacher.php"><i class="glyphicon glyphicon-user text-green"></i> Professor</a>
                            </li>
                            <li><a href="signatories.php"><i class="glyphicon glyphicon-user text-green"></i>
                                    Signatories</a></li>
                        </ul>
                    </li>

                    <!-- Maintenance Dropdown Menu -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-wrench"></i> Maintenance <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="department.php"><i class="glyphicon glyphicon-user text-green"></i>
                                    Department</a></li>
                            <li><a href="designation.php"><i class="glyphicon glyphicon-cutlery text-green"></i>
                                    Designation</a></li>
                            <li><a href="program.php"><i class="glyphicon glyphicon-cutlery text-green"></i> Program</a>
                            </li>
                            <li><a href="rank.php"><i class="glyphicon glyphicon-send text-green"></i> Rank</a></li>
                            <li><a href="salut.php"><i class="glyphicon glyphicon-user text-green"></i> Salutation</a>
                            </li>
                            <li><a href="sy.php"><i class="glyphicon glyphicon-user text-green"></i> School Year</a>
                            </li>
                            <li><a href="time.php"><i class="glyphicon glyphicon-calendar text-green"></i> Time</a></li>
                        </ul>
                    </li>

                    <!-- Settings Menu -->
                    <li>
                        <a href="settings.php" style="color:#fff;"><i class="glyphicon glyphicon-cog text-red"></i>
                            Settings</a>
                    </li>

                    <!-- Profile Menu -->
                    <li>
                        <a href="profile.php?showModal=true"><i class="glyphicon glyphicon-user text-orange"></i>
                            <?php echo $_SESSION['name']; ?></a>
                    </li>

                    <!-- Logout Menu -->
                    <li>
                        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')"><i
                                class="glyphicon glyphicon-off text-red"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>