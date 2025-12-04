
<?php
require_once("../admin/connection.php");
$sql = "SELECT * FROM job";
$result = mysqli_query($db, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $disabled = ($row['position'] <= 0) ? 'disabled style="pointer-events:none;opacity:0.6;cursor:not-allowed;"' : '';
        $btnText = ($row['position'] <= 0) ? 'Not Available' : 'Apply Now';
        echo '<div class="card android">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p><strong>Required Experience:</strong> ' . intval($row['req_exp']) . ' years</p>';
        echo '<p><strong>Positions Left:</strong> ' . intval($row['position']) . '</p>';
        echo '<a href="applied.php?type=job&id=' . $row['job_id'] . '" class="apply-btn" ' . $disabled . ' onclick="return checkJobRequirements(' . intval($row['req_exp']) . ',' . intval($row['position']) . ');">' . $btnText . '</a>';
        echo '</div>';
    }
} else {
    echo '<div>No job openings available at the moment.</div>';
}
?>
<script>
function checkJobRequirements(reqExp, position) {
    // This function can be extended to check user experience via AJAX if needed
    if (position <= 0) {
        alert('This job is no longer available.');
        return false;
    }
    return true;
}
</script>
