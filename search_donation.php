<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'database.php';
?>

<?php include 'header.php'; ?>
<h2>Search Donations</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
    <div class="form-group">
        <label for="search">Search by Message:</label>
        <input type="text" name="search" class="form-control" id="search" placeholder="Enter search term">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Search">
    </div>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $search_term = "%" . $_GET["search"] . "%";
    $sql = "SELECT * FROM donations WHERE message LIKE ? AND user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $param_search, $param_user_id);
        $param_search = $search_term;
        $param_user_id = $_SESSION["id"];
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered table-striped mt-3">';
                echo '<thead><tr><th>ID</th><th>Amount</th><th>Message</th><th>Date</th></tr></thead><tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["amount"] . '</td>';
                    echo '<td>' . $row["message"] . '</td>';
                    echo '<td>' . $row["donation_date"] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<div class="alert alert-warning">No records found.</div>';
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<?php include 'footer.php'; ?>