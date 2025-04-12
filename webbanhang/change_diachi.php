<?php
require_once('lib_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>THẾ GIỚI ĐỒNG HỒ</title>
  <link rel="shortcut icon" href="assets/Img/logo.jpg" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/change_user_information_processing.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap&amp;_cacheOverride=1679484892371" data-tag="font">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" data-tag="font">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="sweetalert2.min.js"></script>
  <link rel="stylesheet" href="sweetalert2.min.css">
  <style>
    #content-details-user {
      display: flex;
      width: 70%;
      height: 100%;
      background-color: #fff;
      flex-direction: row;
    }

    #edit_infor_user {
      width: 50%;
      height: 100%;
      background-color: #fff;
      margin-top: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    #edit_address_user {
      width: 50%;
      height: 100%;
      background-color: #fff;
      margin-top: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    #titleEditInforUser {
      font-family: 'Roboto';
      font-style: normal;
      font-weight: normal;
      font-size: 20px;
      line-height: 20px;
      letter-spacing: 0.1px;
    }
  </style>
</head>

<body>
  <!--Start: Header-->
  <div id="bar-header">
    <?php
    include("components/header.php");
    ?>
  </div>
  <!--End: Header-->
  <div id="main-user">
    <div id="imagelogo">
      <img id="img-logo" src="assets/img/logo1.jpg" alt="">
    </div>
    <div id="main-content">
      <div id="tab-bar-user">
        <p class="content-tab-bar-userr"> Đổi địa chỉ nhận hàng!
          <!-- <?php echo ("$_SESSION[current_fullName]"); ?>  -->
        </p>
        <!-- <ul id="primary2">
          <li style="margin-bottom: 16px;"><a href="user_information.php">Thông tin tài khoản</a></li>
          <li><a href="my_order.php">Quản lý đơn hàng</a></li>
        </ul> -->

      </div>
      <div id="content-details-user">
        <!-- <div id="user-infor-and-address-user">
                <div id="user-infor">
                    <p style="font-size: 20px;">Thông tin cá nhân | <a href="detail-user.php" style="font-size: 20px;">Chỉnh sửa</a></p>
                    <p>Họ và tên: <?php echo $_SESSION['current_fullName'] ?></p>
                    <p>Email: <?php echo $_SESSION['current_email'] ?></p>
                    <p>Số điện thoại: <?php echo $_SESSION['current_numberPhone'] ?></p>
                </div>
                <hr>
                <div id="address-user">
                    <p style="font-size: 20px;">Địa chỉ nhận hàng | <a href="#" style="font-size: 20px;">Chỉnh sửa</a></p>
                    <p><?php echo $_SESSION['current_houseRoadAddress'] ?>, <?php echo $_SESSION['current_ward'] ?>, <?php echo $_SESSION['current_district'] ?>, <?php echo $_SESSION['current_province'] ?></p>
                </div>
            </div> -->
        <form name="frm" id="" action="modules/change_user_information_processing.php" method="POST" onsubmit="return kiemTra();" style="display: flex;flex-direction: row;width: 100%;">
          <div style="position: absolute;width: 100%;display: flex;flex-direction: row;height: fit-content;align-items: center;">
          <p id="titleEditInforUser" style="padding: 12px;width: fit-content;" class="LabelMedium"></p>
          <div style="height: 100%; width: fit-content;">
          <?php
              if (isset($_SESSION['errorChangeInfor'])) {
                echo '<p id="errorChangeInfor" style="font-size: 12px;line-height: 18.391px;color: red;font-weight: bold;">' . $_SESSION['errorChangeInfor'] . '</p>';
                unset($_SESSION['errorChangeInfor']);
              }
          ?>
          </div>
          </div>
          <div id="edit_infor_user">
          <div>
              <p class="LabelMedium" style="margin-bottom: 4px;">Địa chỉ nhận hàng (*)</p>
              <input class="LabelMedium" name="diaChiNha" type="text" style="padding-left: 6px;width:332px; height:36px; border-style: outset;margin-bottom: 34px; border: 1px solid #674FA3; border-radius: 8px;" value="<?php echo $_SESSION['current_houseRoadAddress'] ?>">
            </div>
            <div style="width: 332px; display:flex;justify-content: center; padding: 0px 24px;">
              <input type="submit" name="btnSubmitEdit" id="btnSubmitEdit" class="containerlogin-text06 LabelLarge" value="Lưu" style="padding: 0px 24px;border: 1px solid #6750A4;">
              </span>
              <input type="button" id="btnQuayveUser" class="containerlogin-text06 LabelLarge" value="Hủy" style="margin-left: 20px;padding: 0px 24px;border: 1px solid #6750A4;" onclick="quayVeUser();">
              </span>
            </div>
            <!-- <div>
              <p class="LabelMedium" style="margin-top: 30px;margin-bottom: 4px;">Họ và tên (*)</p>
              <input class="LabelMedium" name="fullName" type="text" style="padding-left: 6px;width:320px; height:36px;  border-style: outset;margin-bottom: 12px; border: 1px solid #674FA3; border-radius: 8px;" value="<?php echo $_SESSION['current_fullName'] ?>">
            </div> -->
            <div>
              <div style="display: flex; flex-direction:row ;width: fit-content;">
                <!-- <p class="LabelMedium" style="margin-bottom: 4px;">Email </p>
                <p id="error-message" style="display: none; color: red;padding-left: 10px;font-size: 12px;font-weight: bold;line-height: 18.391px;">
                </p> -->
              </div>
              <!-- <input class="LabelMedium" id="email" name="email" type="email" style="padding-left: 6px;width:320px; height:36px; border-style: outset;margin-bottom: 12px; border: 1px solid #674FA3; border-radius: 8px;" value="<?php echo $_SESSION['current_email'] ?>"> -->
            </div>
            <div>
              <div style="display: flex; flex-direction:row ;width: fit-content;">
                <!-- <p class="LabelMedium" style="margin-bottom: 4px;">Số điện thoại</p> -->
                <!-- <p id="phoneNumber-message" style="display: none; color: red;padding-left: 10px;font-size: 12px;font-weight: bold;line-height: 18.391px;"> -->
                </p>
              </div>
              <!-- <input class="LabelMedium" id="numberPhone" name="numberPhone" type="text" style="padding-left: 6px;width:320px; height:36px; border-style: outset;margin-bottom: 12px; border: 1px solid #674FA3; border-radius: 8px;" value="<?php echo $_SESSION['current_numberPhone'] ?>"> -->
            </div>
          </div>
          <div id="edit_address_user">
            
            
           
          </div>
        </form>

      </div>
    </div>
  </div>
  <!--Start: Footer-->
  <div id="my-footer" style="position: absolute;">
    <?php
    include("components/footer.php");
    ?>
  </div>
  <!--End: Footer-->
  <!--Start Điều hướng về trang user-->
  <script>
    function quayVeUser() {
      window.location = "payment.php";
    }
  </script>
  <!--End điều hướng về trang user-->
  
  <!--End checkmail-->

  <!--Start check phone-->
  
   
 
  <!--End check phone-->
  <!--START: Script check các ô-->
  
  <!--END: Script check các ô-->
  <!--START: Script api tỉnh quận huyện xã-->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
  
  
  <!--END: Script api tỉnh quận huyện xã-->

</body>

</html>