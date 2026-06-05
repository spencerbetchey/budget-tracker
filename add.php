<?php

// Reuse connection
include 'db.php';

$error = "";

// Only process the form if it was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $type = $_POST['type'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Validation
    if (empty($type) || empty($category) || empty($amount) || empty($date)) {
        $error = "Please fill in all required fields.";
    } else {
        // Insert the transaction into the database
        $query = "INSERT INTO transactions (type, category, amount, description, date)
                  VALUES ('$type', '$category', '$amount', '$description', '$date')";

        if (mysqli_query($conn, $query)) {
            // Success
            // Redirect back to main page
            header('Location: index.php');
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Add Transaction</h1>

    <!-- Show error message if there is one -->
    <?php if ($error != "") { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST" action="add.php">

        <!-- Type -->
        <div class="mb-3">
            <label class="form-label">Type *</label>
            <select name="type" class="form-select">
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label class="form-label">Category *</label>
            <input type="text" name="category" class="form-control" placeholder="e.g. Food, Rent, Salary">
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label class="form-label">Amount *</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" name="amount" class="form-control" step="0.01" min="0" placeholder="0.00">
            </div>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" placeholder="Optional notes">
        </div>

        <!-- Date -->
        <div class="mb-3">
            <label class="form-label">Date *</label>
            <input type="date" name="date" class="form-control">
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-primary">Save Transaction</button>
        <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>