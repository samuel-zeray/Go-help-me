<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'database.php';

$amount = $message = "";
$amount_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["amount"]))) {
        $amount_err = "Please enter a donation amount.";
    } elseif (!is_numeric(trim($_POST["amount"]))) {
        $amount_err = "Please enter a valid amount.";
    } else {
        $amount = trim($_POST["amount"]);
    }

    $message = trim($_POST["message"]);
    $id = trim($_POST["id"]);

    if (empty($amount_err)) {
        $sql = "UPDATE donations SET amount = ?, message = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("dsi", $param_amount, $param_message, $param_id);
            $param_amount = $amount;
            $param_message = $message;
            $param_id = $id;
            if ($stmt->execute()) {
                header("location: dashboard.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);
        $sql = "SELECT * FROM donations WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $param_id);
            $param_id = $id;
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $amount = $row["amount"];
                    $message = $row["message"];
                } else {
                    echo "Error retrieving record.";
                }
            }
            $stmt->close();
        }
        $conn->close();
    } else {
        echo "Invalid request.";
    }
}
?>

<?php include 'header.php'; ?>
<h2>Edit Donation</h2>
<p>Please edit the inputs and submit to update the donation.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
        <label>Amount</label>
        <input type="text" name="amount" class="form-control" value="<?php echo $amount; ?>">
        <span class="help-block"><?php echo $amount_err; ?></span>
    </div>
    <div class="form-group">
        <label>Message</label>
        <textarea name="message" class="form-control"><?php echo $message; ?></textarea>
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
    </div>
</form>
<?php include 'footer.php'; ?>