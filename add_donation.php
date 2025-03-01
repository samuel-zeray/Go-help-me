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

    if (empty($amount_err)) {
        $sql = "INSERT INTO donations (user_id, amount, message) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ids", $param_user_id, $param_amount, $param_message);
            $param_user_id = $_SESSION["id"];
            $param_amount = $amount;
            $param_message = $message;
            if ($stmt->execute()) {
                header("location: dashboard.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<?php include 'header.php'; ?>
<h2>Add Donation</h2>
<p>Please fill this form to add a donation.</p>
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
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
    </div>
</form>
<?php include 'footer.php'; ?>