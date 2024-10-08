<?php
include_once 'functions/connection.php';

$sql = 'SELECT * FROM items';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();


foreach ($results as $row) {

?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['unit']; ?></td>
        <td><?php echo $row['stock']; ?></td>
        <td>$<?php echo $row['price']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td class="text-center">
            <a class="mx-1 text-decoration-none text-success" href="#" data-bs-target="#stock-in" data-bs-toggle="modal" data-id="<?php echo $row['id']?>"><i class="far fa-arrow-alt-circle-up text-success" style="font-size: 20px;"></i> Stock In</a>
            <a class="mx-1 text-decoration-none" href="#" data-bs-target="#stock-out" data-bs-toggle="modal" data-id="<?php echo $row['id']?>"><i class="far fa-arrow-alt-circle-down" style="font-size: 20px;"></i> Stock Out</a>
            <a class="mx-1 text-decoration-none text-warning" href="#" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id']?>" data-name="<?php echo $row['name']?>" data-unit="<?php echo $row['unit']?>"><i class="far fa-edit text-warning" style="font-size: 20px;"></i> Update</a>
            <a class="mx-1 text-decoration-none text-danger" href="#" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id']?>"><i class="far fa-trash-alt text-danger" style="font-size: 20px;"></i> Remove</a>
        </td>
        <?php

        ?>

    </tr>

<?php
}
