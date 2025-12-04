<?php
// Import dashboard.css for card styles
echo '<link rel="stylesheet" href="../styles/dashboard.css">';
require_once("../admin/connection.php");
$sql = "SELECT course_id, title, description, language, duration, price FROM course";
$res = mysqli_query($db, $sql);
if (!$res) {
    echo '<div style="color:red;">Error loading courses.</div>';
    return;
}
while ($row = mysqli_fetch_assoc($res)) {
    ?>
    <div class="card webdev">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p><strong>Language:</strong> <?= htmlspecialchars($row['language']) ?></p>
        <p><strong>Duration:</strong> <?= htmlspecialchars($row['duration']) ?></p>
        <p><strong>Price:</strong> ₹<?= number_format($row['price']) ?></p>
        <a href="./applied.php?type=course&id=<?= $row['course_id'] ?>" class="apply-btn">Enroll Now</a>
    </div>
    <?php
}
?>