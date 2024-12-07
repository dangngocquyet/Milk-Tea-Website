<?php 
    include 'header.php';
    // include '../connect.php';
    if (isset($_COOKIE["user"])) {
        $user = $_COOKIE["user"];
        foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
            $permission = $row['phanquyen'];
        }
        if ($permission==1) {
            if (isset($_POST['them'])) {
                $ten = $_POST["ten"];
                $id_danhmuc = $_POST["danhmuc"];
                $gia = $_POST["gia"];
                $anh1 = $_FILES['anh1']['name'];
                $tmp1 = $_FILES['anh1']['tmp_name'];
                $type1 = $_FILES['anh1']['type'];
                $mota = $_POST["mota"];
                $dir = '../img/product/';
                
                selectAll("INSERT INTO sanpham VALUES(NULL,$id_danhmuc,'$ten',$gia,'$anh1','$mota',0,1)");
                header('location:product.php');
            }
        ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row ">
                        <div class="col-12 grid-margin">
                        <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm Sản Phẩm</h4>
                    <form class="forms-sample" action="" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label for="exampleInputName1">Tên Sản Phẩm</label>
                        <input type="text" name = "ten" required class="form-control text-light" placeholder="Nhập tên sản phẩm">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Giá</label>
                        <input type="number" name ="gia" required class="form-control text-light" placeholder="Nhập giá bán">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail3">Danh mục</label>
                        <select required name="danhmuc" id="input" class="form-control text-light">
                        <?php
                        foreach (selectAll("SELECT * FROM danhmuc ") as $item) {
                        ?>
                            <option value="<?= $item['id_dm'] ?>"><?= $item['danhmuc'] ?></option>
                        <?php
                        }
                        ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Ảnh Sản Phẩm</label>
                        <input type="file" name="anh1" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Mô Tả Ngắn</label>
                        <textarea type="text" name ="mota" required class="form-control text-light" rows="3" style="line-height: 2" placeholder="Nhập mô tả ngắn gọn"></textarea>
                      </div>
                      <button type="submit" name="them" class="btn btn-primary mr-2">Thêm sản phẩm</button>
                      <a class="btn btn-dark" href="product.php" >Hủy</a>
                    </form>
                  </div>
                </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
    include 'footer.php';
?>