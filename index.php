<?php

// Reuse connection
include 'db.php';

// Get total income
$incomeResult = mysqli_query($conn, "SELECT SUM(amount) AS total FROM transactions WHERE type = 'income'");
$incomeRow = mysqli_fetch_assoc($incomeResult);
$totalIncome = $incomeRow['total'] ? $incomeRow['total'] : 0;

// Get total expenses
$expenseResult = mysqli_query($conn, "SELECT SUM(amount) AS total FROM transactions WHERE type = 'expense'");
$expenseRow = mysqli_fetch_assoc($expenseResult);
$totalExpenses = $expenseRow['total'] ? $incomeRow['total'] : 0;

// Calculate balance
$balance = $totalIncome - $totalExpenses;

// Get all transactions, ordered by date
$transactions = mysqli_query($conn, "SELECT * FROM transactions ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Personal Budget Tracker</h1>

    <!-- Summary Cards: Income, Balance, Expenses -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Income</h5>
                    <p class="card-text fs-4">$<?php echo number_format($totalIncome, 2); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Expenses</h5>
                    <p class="card-text fs-4">$<?php echo number_format($totalExpenses, 2); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white <?php echo $balance >= 0 ? 'bg-primary' : 'bg-warning'; ?>">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <p class="card-text fs-4">$<?php echo number_format($balance, 2); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Transaction Button -->
    <a href="add.php" class="btn btn-primary mb-4">+ Add Transaction</a>

    <!-- Transactions Table -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Category</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($transactions)) { ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td>
                    <?php if ($row['type'] == 'income') { ?>
                        <span class="badge bg-success">Income</span>
                    <?php } else { ?>
                        <span class="badge bg-danger">Expense</span>
                    <?php } ?>
                </td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>$<?php echo number_format($row['amount'], 2); ?></td>
                <td>
                    <a href="delete.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this transaction?')">
                        Delete
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>