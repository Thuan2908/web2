<?php
    include './connectdb.php';

    if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
        $orderID = mysqli_real_escape_string($con, $_GET['order_id']);
        $sql = "SELECT
                    ol.Quantity,
                    ol.UnitPrice,
                    p.ProductName
                FROM
                    \`order_line\` ol
                JOIN
                    \`product\` p ON ol.ProductID = p.ProductID
                WHERE
                    ol.OrderID = 'OD00000017'";
        $result = mysqli_query($con, $sql);
        $details = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $details[] = $row;
            }
            echo json_encode(array('success' => true, 'details' => $details));
        } else {
            echo json_encode(array('success' => true, 'details' => array())); // Không có chi tiết
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Thiếu Order ID.'));
    }

    mysqli_close($con);
    ?>