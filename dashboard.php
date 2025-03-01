<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'database.php';
?>

<?php include 'header.php'; ?>
<h2>Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
<a href="add_donation.php" class="btn btn-primary">Add Donation</a>
<a href="search_donation.php" class="btn btn-dark">Search Donation</a>
<table class="table table-bordered table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM donations WHERE user_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $param_user_id);
            $param_user_id = $_SESSION["id"];
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["amount"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["donation_date"] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_donation.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>...";
                    echo "<a href='delete_donation.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            $stmt->close();
        }
        ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
