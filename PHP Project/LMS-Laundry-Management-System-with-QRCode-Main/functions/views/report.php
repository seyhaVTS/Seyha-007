<?php
include_once 'functions/connection.php';

// Check if the form was submitted and the necessary fields are set
if (isset($_POST['fr_date'], $_POST['to_date'])) {
    $v_fr = $_POST['fr_date'];
    $v_to = $_POST['to_date'];

    $sql = 'SELECT t.id, t.total,DATE_FORMAT(t.created_at, "%d-%m-%Y  %H:%i:%s") as created_at, c.fullname,
               @rownum := @rownum + 1 AS rownum
            FROM transactions AS t
            JOIN customers AS c ON t.customer_id = c.id
            JOIN (SELECT @rownum := 0) r
            WHERE t.created_at >= :fr_date
            AND t.created_at < :to_date + INTERVAL 1 DAY
            and t.status ="completed"
            ORDER BY rownum ASC;';

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fr_date', $v_fr);
    $stmt->bindParam(':to_date', $v_to);
    $stmt->execute();
    $results = $stmt->fetchAll();

    $total_amount = 0;
    foreach ($results as $row) {
        $total_amount += $row['total'];
        echo '<tr>';
        echo '<td>' . $row['rownum'] . '</td>';
        echo '<td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/profile.png">' . $row['fullname'] . '</td>';
        echo '<td>$' . number_format($row['total'], 2) . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '</tr>';
    }


    // Display the subtotal in the footer
    echo '<tfoot>';
    echo '<tr>';
    echo '<td colspan="2">Total:</td>';
    echo '<td>$' . number_format($total_amount, 2) . '</td>';
    echo '<td></td>';
    echo '</tr>';
    echo '</tfoot>';
}
?>