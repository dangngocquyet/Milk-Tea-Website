<?php 
    include 'header.php';

    if (isset($_COOKIE["user"])) {
        $user = $_COOKIE["user"];
        foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
            $permission = $row['phanquyen'];
        }
        if ($permission==1) {
            if (isset($_GET["id"])) {
                foreach (selectAll("SELECT * FROM sanpham WHERE id={$_GET['id']}") as $item) {
                    $ten = $item['ten'];
                    $id_danhmuc = $item['id_danhmuc'];
                    $gia = $item['gia'];
                    $mota = $item['mota'];
                }
            }
            if (isset($_POST['sua'])) {
                $ten = $_POST["ten"];
                $id_danhmuc = $_POST["danhmuc"];
                $gia = $_POST["gia"];
                $anh1 = $_FILES['anh1']['name'];
                $tmp1 = $_FILES['anh1']['tmp_name'];
                $type1 = $_FILES['anh1']['type'];
                $mota = $_POST["mota"];
                $dir = '../img/product/';
                move_uploaded_file($tmp1, $dir . $anh1);
                if (empty($_FILES['anh1']['name'])) {
                    selectAll("UPDATE sanpham SET ten='$ten',id_danhmuc='$id_danhmuc',gia='$gia',mota='$mota' WHERE id={$_GET['id']}");
                    header('location:product.php');
                }else{
                    selectAll("UPDATE sanpham SET ten='$ten',id_danhmuc='$id_danhmuc',gia='$gia',anh1='$anh1',mota='$mota' WHERE id={$_GET['id']}");
                    header('location:product.php');
                }
            }
        ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row ">
                        <div class="col-12 grid-margin">
                        <div class="card">
                  <div class="card-body addfont">
                    <h4 class="card-title addfont">Sửa Sản Phẩm</h4>
                    <form class="forms-sample" action="" method="post" enctype="multipart/form-data">

                      <div class="form-group addfont">
                        <label for="exampleInputName1">Tên Sản Phẩm</label>
                        <input type="text" value="<?= $ten ?>" name = "ten" required class="form-control text-light" placeholder="Nhập tên sản phẩm">
                      </div>

                      <div class="form-group addfont">
                        <label for="exampleInputName1">Giá</label>
                        <input type="number" value="<?= $gia ?>" name ="gia" required class="form-control text-light" placeholder="Nhập giá bán">
                      </div>

                      <div class="form-group addfont">
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

                      <div class="form-group addfont">
                        <label>Ảnh Sản Phẩm</label>
                        <input type="file" name="anh1" class="form-control">
                      </div>

                      <div class="form-group addfont">
                        <label for="exampleTextarea1">Mô Tả Ngắn</label>
                        <textarea type="text" name ="mota" required class="form-control text-light" rows="3" style="line-height: 2" placeholder="Nhập mô tả ngắn gọn"><?= $mota ?></textarea>
                      </div>
                      <button type="submit" name="sua" class="btn btn-primary mr-2">Sửa sản phẩm</button>
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