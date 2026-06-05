<?php

// Reuse connection
include 'db.php';

// Get the transaction id from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the transaction with that id
    $query = "DELETE FROM transactions WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        // Success 
        // Redirect back to main page
        header('Location: index.php');
        exit();
    } else {
        echo "Something went wrong. Could not delete transaction.";
    }
} else {
    // No id provided
    // Redirect back to main page
    header('Location: index.php');
    exit();
}
?>