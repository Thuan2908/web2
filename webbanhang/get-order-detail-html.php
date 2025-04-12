<?php
include './connectdb.php';

$orderID = $_GET['order_id'];

$sqlOrder = "SELECT o.*, u.FullName, u.UserID 
             FROM `order` o 
             JOIN user u ON o.UserID = u.UserID 
             WHERE o.OrderID = '$orderID'";
$resultOrder = mysqli_query($con, $sqlOrder);
if (!$resultOrder || mysqli_num_rows($resultOrder) == 0) {
    echo "<div>Không tìm thấy đơn hàng.</div>";
    exit;
}
$order = mysqli_fetch_assoc($resultOrder);

$products = mysqli_query($con, "SELECT p.ProductID, p.ProductName, oi.Quantity, oi.Price
                                FROM orderitem oi
                                JOIN product p ON oi.ProductID = p.ProductID
                                WHERE oi.OrderID = '$orderID'");

function formatCurrency($val) {
    return number_format($val) . ' VND';
}
?>

<div class="order-popup">
    <h3>Chi Tiết Đơn Hàng</h3>
    <div class="order-info-grid">
        <div><strong>Mã đơn hàng</strong><input disabled value="<?= $order['OrderID'] ?>"></div>
        <div><strong>Hình thức</strong><input disabled value="<?= $order['PaymentMethod'] ?>"></div>
        <div><strong>Người dùng</strong><input disabled value="<?= $order['UserID'] ?>_<?= $order['FullName'] ?>"></div>
        <div><strong>Tình trạng</strong><input disabled value="<?= $order['Status'] ?>"></div>
        <div><strong>Ngày đặt</strong><input disabled value="<?= $order['OderDate'] ?>"></div>
        <div><strong>Địa chỉ</strong><input disabled value="<?= $order['Address'] ?>"></div>
    </div>

    <table class="order-product-table">
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Tổng (VND)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?= $p['ProductID'] ?></td>
                <td><?= htmlspecialchars($p['ProductName']) ?></td>
                <td><?= formatCurrency($p['Price']) ?></td>
                <td><?= $p['Quantity'] ?></td>
                <td><?= formatCurrency($p['Price'] * $p['Quantity']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="order-summary">
        <p><strong>Tổng đơn:</strong> <?= formatCurrency($order['OrderTotal']) ?></p>
        <p><strong>Phí giao hàng:</strong> <?= formatCurrency($order['ShippingFee']) ?></p>
        <p><strong>Mã giảm giá:</strong> <?= $order['DiscountCode'] ?? 'Không' ?></p>
        <p><strong>Tổng giảm:</strong> <?= formatCurrency($order['DiscountAmount']) ?></p>
        <p><strong>Thành tiền:</strong> <?= formatCurrency($order['OrderTotal'] + $order['ShippingFee'] - $order['DiscountAmount']) ?></p>
    </div>
</div>
