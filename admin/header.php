<?php 
    include '../connect.php';
    if (isset($_GET["logout"])) {
        setcookie("user", null, -1, '/');
        header('location:../hehe.php');
    }
    if (isset($_COOKIE["user"])) {
        $user = $_COOKIE["user"];
        foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
            $permission = $row['phanquyen'];
        }
        if ($permission==1) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <link rel="icon" href="../img/logos.png">
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <style>
      .addfont{
        font-family: 'Arial';
      }
      
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href=""><img src="assets/images/logo.png" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href=""><img src="assets/images/logo-mini.png" alt="logo" /></a>
        </div>
        <ul class="nav ">
          <!-- <li class="nav-item profile">
            <div class="profile-desc">

            </div>
          </li> -->
          <li class="nav-item menu-items ">
            <a class="nav-link" href="index.php">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title addfont">Thống Kê Doanh Thu</span>
            </a>
          </li>
          
          <li class="nav-item menu-items">
            <a class="nav-link" href="category.php">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted-type"></i>
              </span>
              <span class="menu-title addfont">Danh Mục Sản Phẩm</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="product.php">
              <span class="menu-icon">
                <i class="mdi mdi-cellphone-iphone"></i>
              </span>
              <span class="menu-title addfont">Sản Phẩm</span>
            </a>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" href="cart.php?action">
              <span class="menu-icon">
                <i class="mdi mdi-cart"></i>
              </span>
              <span class="menu-title addfont">Đơn Hàng</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.png" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">

            <ul class="navbar-nav w-100">

            </ul>
            <ul class="navbar-nav navbar-nav-right">


                  <!-- <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a> -->
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="?logout">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1 addfont">Đăng Xuất</p>
                    </div>
                  </a>
                  <!-- <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div> -->
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
    <?php
        }else{
            include '404.php';
        }
    }else{
        include '404.php';
    }
?>
