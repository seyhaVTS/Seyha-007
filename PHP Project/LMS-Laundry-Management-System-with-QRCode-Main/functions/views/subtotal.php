<?php
include_once 'functions/connection.php';

// Check if the form was submitted and the necessary fields are set
if (isset($_POST['fr_date'], $_POST['to_date'])) {
    $v_fr = $_POST['fr_date'];
    $v_to = $_POST['to_date'];

    // Query to fetch results
    $sql = 'SELECT total
            FROM transactions
            WHERE created_at >= :fr_date
            AND created_at < :to_date + INTERVAL 1 DAY;';

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fr_date', $v_fr);
    $stmt->bindParam(':to_date', $v_to);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $total = 0;

    foreach ($results as $row) {
        $total += $row['total'];
    }

    // Display table data
    foreach ($results as $row) {
        // Display your table rows here
    }

    // Table footer content
    echo '<tr>';
    echo '<td style="text-align: right;" colspan="2">Total: $' . number_format($total, 2) . '</td>';
    echo '</tr>';
}
?>