<?php
include './connect.php';
if (isset($_GET["id"])) {
    $idSanpham = $_GET['id'];
    selectAll("UPDATE sanpham SET luotxem=luotxem+1 WHERE id=$idSanpham");
    foreach (selectAll("SELECT * FROM sanpham WHERE id=$idSanpham") as $row) {
        $tensp = $row['ten'];
        $gia = $row['gia'];
        $anh1 = $row['anh1'];
        $luotxem = $row['luotxem'];
        $cateid = $row['id_danhmuc'];
        $mota =$row['mota'];
        foreach (selectAll("SELECT * FROM danhmuc WHERE id_dm={$row['id_danhmuc']}") as $item) {
            $danhmuc = $item['danhmuc'];
        }
    }
}
?>
<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Smobile</title>
    <link rel="icon" href="img/logos.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/lightslider.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
.header_bg {
    background-color: #ecfdff;
    height: 230px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.padding_top1{
    padding-top:20px;
}
.a1{
    padding-top:130px;
}

.a2{
    height: 230px;

}
.form-rep{
    display: none;
}
.showformrepcmt:checked + .form-rep{
    display: block;
}    
</style>

<body>

    <?php include 'header.php';?>

  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb header_bg">
        <div class="container">
            <div class="row justify-content-center a2">
                <div class="col-lg-8 a2">
                        <div class="a1">
                            <h2 class="addfont">Chi Tiết Sản Phẩm</h2>
                        </div>
                </div>
            </div>
        </div>
    </section>
  <!-- breadcrumb end-->
    <!--================End Home Banner Area =================-->

    <!--================Single Product Area =================-->
    <div class="product_image_area " style="padding-top: 100px">
        <div class="container">
            <div class="row s_product_inner justify-content-between">
                <?php 
                    foreach (selectAll("SELECT * FROM sanpham WHERE id=$idSanpham") as $item) {
                        $giatien = $item['gia'];
                        ?>
                            <div class="col-lg-7 col-xl-7">
                                <div class="product_slider_img">
                                    <div id="vertical">
                                        <div data-thumb="img/product/<?= $item['anh1'] ?>">
                                            <img src="img/product/<?= $item['anh1'] ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-xl-4">
                                <div class="s_product_text">
                                    <h3><?= $item['ten'] ?></h3>
                                    <h2 > <?= number_format($item['gia']) . 'đ' ?></h2>
                                    <ul class="list">
                                        <li>
                                            <a class="active" href="category.php?id=<?= $item['id_danhmuc'] ?>">
                                                <span>Danh mục</span> : <?= $danhmuc ?></a>
                                        </li>
                                        
                                    </ul>
                                    <p>
                                        <?= $mota ?>
                                    </p>
                                    <form class="card_area d-flex justify-content-between align-items-center" action="" method="POST">
                                        <div class="product_count">
                                            <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                                            <input type="number" hidden name="giatien" value="<?= $giatien ?>">
                                            <input class="input-number" name="soluong" type="number" value="1" min="1" max="100" readonly>
                                            <span class="number-increment"> <i class="ti-plus"></i></span>
                                        </div>


                                        <!-- if((rowCount đơn hàng where status =0) =0){
                                                insert dơn hàng ;
                                                insert ctđơn hàng (fk là id đơn hàng mới tạo, và thông tin sản phẩm vừa thêm);
                                            }
                                            else{
                                                ìf(selectAll ct đơn hàng đã có sp muốn thêm ){
                                                    update số lượng
                                                }
                                                else{
                                                    insert ctđơn hàng (fk là id đơn hàng mới tạo, và thông tin sản phẩm vừa thêm);

                                                }
                                            } -->


                                        <?php 
                                            if (isset($_POST["addcart"])) {
                                                if (isset($_COOKIE["user"])) {
                                                    $taikhoan = $_COOKIE["user"];
                                                    $soluong = $_POST["soluong"];
                                                    $giatien = $_POST["giatien"];
                                                    foreach (selectAll("SELECT * FROM `taikhoan` WHERE taikhoan='$taikhoan'") as $item) {
                                                        $id_nguoidung = $item['id'];
                                                    }
                                                    if (rowCount("SELECT * FROM donhang WHERE status=0 && id_taikhoan=$id_nguoidung")>0) {
                                                        foreach (selectAll("SELECT * FROM donhang WHERE status=0 && id_taikhoan=$id_nguoidung") as $item) {
                                                            $idDhcu= $item['id'];
                                                        }
                                                        if (rowCount("SELECT * FROM chitiet WHERE id_donhang = $idDhcu && id_sanpham = $idSanpham")>0) {
                                                            selectAll("UPDATE chitiet SET soluong= $soluong+soluong WHERE id_donhang = $idDhcu && id_sanpham = $idSanpham");
                                                        }else{
                                                            selectAll("INSERT INTO chitiet VALUES(null,$idDhcu,$idSanpham,$soluong,$giatien)");
                                                        }
                                                    }else{
                                                        selectAll("INSERT INTO donhang VALUES(null,$id_nguoidung,0,0,null,null)");
                                                        foreach (selectAll("SELECT * FROM donhang WHERE status=0 && id_taikhoan=$id_nguoidung") as $item) {
                                                            $idDhmoi= $item['id'];
                                                        }
                                                        selectAll("INSERT INTO chitiet VALUES(null,$idDhmoi,$idSanpham,$soluong,$giatien)");
                                                    }
                                                    
                                                    echo "<meta http-equiv='refresh' content='0'>";
                                                }else{
                                                    echo "<script>alert('Vui lòng đăng nhập để mua hàng')</script>";
                                                }
                                            }
                                        ?>
                                        <input class="btn_3" name="addcart" type="submit" value="Thêm vào giỏ hàng"/>
                                    </form>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Mô tả</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <p>
                        <?= $chitiet ?>
                    </p>
                </div>
                
                
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->

    <!-- product_list part start-->
    <section class="product_list best_seller">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        <h3>Sản Phẩm Liên Quan</h3>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-12">
                    <div class="best_product_slider owl-carousel">
                    <?php 
                        foreach (selectAll("SELECT * FROM sanpham WHERE id_danhmuc = $cateid AND NOT(id = $idSanpham) ") as $item) {
                    ?>
                        <div class="single_product_item">
                            <a href="detail.php?id=<?= $item['id'] ?>" >
                                <img src="img/product/<?= $item['anh1'] ?>" alt="">
                            </a>
                            <div class="single_product_text">
                                <a href="detail.php?id=<?= $item['id'] ?>" >
                                <h4><?= $item['ten'] ?></h4>
                                <h3><?= number_format($item['gia']) . 'đ' ?></h3>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product_list part end-->

    <?php include 'footer.php';?>


    <!-- jquery plugins here-->
    <!-- jquery -->
    <script src="js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="js/lightslider.min.js"></script>
    <!-- swiper js -->
    <script src="js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="js/slick.min.js"></script>
    <script src="js/swiper.jquery.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/stellar.js"></script>
    <!-- custom js -->
    <script src="js/theme.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>

