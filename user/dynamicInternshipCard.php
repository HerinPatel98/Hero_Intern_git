<?php
echo '<link rel="stylesheet" href="../styles/dashboard.css">';
require_once("../admin/connection.php");
$sql = "SELECT internship_id, title, description, req_language, price FROM internship";
$res = mysqli_query($db, $sql);
if (!$res) {
    echo '<div style="color:red;">Error loading internships.</div>';
    return;
}
while ($row = mysqli_fetch_assoc($res)) {
    ?>
    <div class="card uiux">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p><strong>Required Language:</strong> <?= htmlspecialchars($row['req_language']) ?></p>
        <p><strong>Price:</strong> ₹<?= number_format($row['price']) ?></p>
        <a href="./applied.php?type=internship&id=<?= $row['internship_id'] ?>" class="apply-btn">Apply Now</a>
    </div>
    <?php
}
?>