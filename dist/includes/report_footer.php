<style>
    .signature-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 20px;
    }

    .signature {
        text-align: left;
        margin-right: 20px;
    }

    .signature span {
        display: block;
    }

    .signature-content {
        margin-left: 30px;
    }
</style>

<div class="signature-section">
    <div class="signature">
        <span>Prepared by:</span><br><br>
        <div class="signature-content">
            <?php 
                include('../dist/includes/dbcon.php');
                $id=$_SESSION['id'];
                $query=mysqli_query($con,"select * from signatories natural join member natural join designation where seq='1' and set_by='$id'")or die(mysqli_error($con));
                $row=mysqli_fetch_array($query);
                echo "<span>$row[member_first] $row[member_last]</span>";
                echo "<span>$row[designation_name]</span>";
            ?>
        </div>
    </div>

    <div class="signature">
        <span>Recommending Approval:</span><br><br>
        <div class="signature-content">
            <?php 
                $query=mysqli_query($con,"select * from signatories natural join member natural join designation where seq='2' and set_by='$id'")or die(mysqli_error($con));
                $row=mysqli_fetch_array($query);
                echo "<span>$row[member_first] $row[member_last]</span>";
                echo "<span>$row[designation_name]</span>";
            ?>
        </div>
    </div>

    <div class="signature">
        <span>Approved:</span><br><br>
        <div class="signature-content">
            <?php 
                $query=mysqli_query($con,"select * from signatories natural join member natural join designation where seq='4' and set_by='$id'")or die(mysqli_error($con));
                $row=mysqli_fetch_array($query);
                echo "<span>$row[member_first] $row[member_last]</span>";
                echo "<span>$row[designation_name]</span>";
            ?>
        </div>
    </div>
</div>
