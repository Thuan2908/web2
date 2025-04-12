<?php
include './sidebar.php';
include './container-header.php';

$dateFrom = !empty($_GET['date-from']) ? $_GET['date-from'] : date('Y-m-d', strtotime('-30 days')); // Mặc định 30 ngày trước
$dateTo = !empty($_GET['date-to']) ? $_GET['date-to'] : date('Y-m-d');

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    eventForSideBar(0);
    setValueHeader("Thống kê Khách Hàng Mua Nhiều Nhất");
</script>
<link rel="stylesheet" href="./assets/CSS/statistic.css">
<style>
        .statistic__top-customers {
    margin-top: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.statistic__top-customers-header {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
}

.top-customers__search {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.top-customers__search label {
    margin-right: 10px;
    font-weight: bold;
    color: #555;
}

.top-customers__search input[type="date"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 5px;
    width: 120px; /* Adjust width as needed */
}

.top-customers__search button {
    padding: 8px 15px;
    background-color: #5cb85c; /* Green button */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.top-customers__search button:hover {
    background-color: #4cae4c;
}

.top-customers__list {
    list-style: none;
    padding: 0;
}

.top-customers__item {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: white;
    font-size : 15px;
}

.customer-info {
    font-weight: bold;
    margin-bottom: 10px;
    /* color: #007bff; Blue customer info */
}

.order-list {
    list-style: none;
    padding-left: 20px; /* Indent the order list */
}

.order-item {
    margin-bottom: 5px;
}

.order-link {
    color: #007bff; /* Blue order link */
    text-decoration: none;
}

.order-link:hover {
    text-decoration: underline;
}

.total-purchase {
    margin-top: 10px;
    font-weight: bold;
    color: #28a745; /* Green total purchase */
}
</style>

<div class="statistic">
    <div class="statistic__top-customers">
        <p class="statistic__top-customers-header">Thống Kê 5 Khách Hàng Mua Nhiều Nhất</p>
        <form class="top-customers__search" method="GET">
            <label for="date-from">Từ ngày:</label>
            <input type="date" id="date-from" name="date-from" value="<?= $dateFrom ?>">
            <label for="date-to">Đến ngày:</label>
            <input type="date" id="date-to" name="date-to" value="<?= $dateTo ?>">
            <button type="submit">Thống Kê</button>
        </form>

        <ul class="top-customers__list">
            <?php
            include './connectdb.php';

            $sqlTopCustomers = "SELECT
                                    u.UserID,
                                    u.FullName,
                                    u.Email,
                                    SUM(o.OrderTotal) AS TotalPurchase
                                FROM
                                    `user` u
                                JOIN
                                    `order` o ON u.UserID = o.UserID
                                WHERE
                                    DATE(o.OderDate) BETWEEN '$dateFrom' AND '$dateTo'
                                GROUP BY
                                    u.UserID
                                ORDER BY
                                    TotalPurchase DESC
                                LIMIT 5";

            $resultTopCustomers = mysqli_query($con, $sqlTopCustomers);

            if (mysqli_num_rows($resultTopCustomers) > 0) {
                while ($rowCustomer = mysqli_fetch_assoc($resultTopCustomers)) {
                    $userID = $rowCustomer['UserID'];
                    $fullName = $rowCustomer['FullName'];
                    $email = $rowCustomer['Email'];
                    $totalPurchase = number_format($rowCustomer['TotalPurchase']);

                    echo '<li class="top-customers__item">';
                    echo '<div class="customer-info">Khách hàng: ' . htmlspecialchars($fullName) . ' </div>';

                    // (' . htmlspecialchars($email) . ')
                    echo '<ul class="order-list">';

                    $sqlOrders = "SELECT
                                        o.OrderID,
                                        o.OderDate,
                                        o.OrderTotal
                                    FROM
                                        `order` o
                                    WHERE
                                        o.UserID = '$userID' AND DATE(o.OderDate) BETWEEN '$dateFrom' AND '$dateTo'
                                    ORDER BY
                                        o.OderDate DESC";

                    $resultOrders = mysqli_query($con, $sqlOrders);

                    if (mysqli_num_rows($resultOrders) > 0) {
                        while ($rowOrder = mysqli_fetch_assoc($resultOrders)) {
                            $orderID = $rowOrder['OrderID'];
                            $orderDate = date('d/m/Y H:i:s', strtotime($rowOrder['OderDate']));
                            $orderTotal = number_format($rowOrder['OrderTotal']);
                            echo '<li class="order-item">Đơn hàng: <a class="order-link" href="order-detail.php  ?order_id=' . htmlspecialchars($orderID) . '">#' . htmlspecialchars($orderID) . '</a> (Ngày: ' . $orderDate . ', Tổng: ' . $orderTotal . ' VND)</li>';
                        }
                    } else {
                        echo '<li class="order-item">Không có đơn hàng nào trong khoảng thời gian này.</li>';
                    }

                    echo '</ul>';
                    echo '<div class="total-purchase">Tổng mua: ' . $totalPurchase . ' VND</div>';
                    echo '</li>';
                }
            } else {
                echo '<li>Không có khách hàng mua hàng trong khoảng thời gian này.</li>';
            }

            mysqli_close($con);
            ?>
        </ul>
    </div>
</div>

<?php include './container-footer.php' ?>