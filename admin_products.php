<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $tahun = $_POST['tahun'];
   $penulis = $_POST['penulis'];
   $penerbit = $_POST['penerbit'];
   $kategori = $_POST['kategori'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Produk Sudah Ada';
   }else{
      $add_product_query = mysqli_query($conn, 
      "INSERT INTO `products`(name, price, tahunTerbit, namaPenulis, penerbit, kategori, image) 
      VALUES('$name', '$price', '$tahun', '$penulis', '$penerbit', '$kategori', '$image')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Produk Berhasil Ditambahkan';
            header('location:admin_products.php');
            exit();
         }
      }else{
         $message[] = 'Produk Gagal Ditambahkan';
      }
   }
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
   
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $update_tahun = $_POST['update_tahun'];
   $update_penulis = $_POST['update_penulis'];
   $update_penerbit = $_POST['update_penerbit'];
   $update_kategori = $_POST['update_kategori'];

   mysqli_query($conn, "UPDATE `products` 
   SET name = '$update_name', 
   price = '$update_price', 
   tahunTerbit = '$update_tahun',
   namaPenulis = '$update_penulis',
   penerbit = '$update_penerbit',
   kategori = '$update_kategori' 
   WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }
   $message[] = 'Produk Berhasil Diubah';
   header('location:admin_products.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Gramedia Bookstore</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
   <link rel="stylesheet" href="css/1adminpage.css">
   
</head>

<body>

   <div class="app">

      <header class="app-header">

         <div class="app-header-logo">
            <div class="logo">
               <span class="logo-icon">
                  <img src="https://assets.codepen.io/285131/almeria-logo.svg" />
               </span>
               <h1 class="logo-title">
                  <span>Gramedia</span>
                  <span>Book Store</span>
               </h1>
            </div>
         </div>

         <div class="app-header-actions">
            <button class="user-profile"> <!-- Nama user  -->
               <span> Hi,
                  <?php echo $_SESSION['admin_name']; ?>
               </span>
               <span>
                  <img src="images/profildefault.jpg" alt="">
               </span>
            </button>
         </div>

      </header>

      <div class="app-body">

         <div class="app-body-navigation">
            <nav class="navigation">
               <a href="1adminpage.php">
                  <i class="ph-browsers"></i>
                  <span>Dashboard</span>
               </a>
               <a href=admin_products.php>
                  <i class="ph-check-square"></i>
                  <span>Products</span>
               </a>
               <a href="admin_orders.php">
                  <i class="ph-swap"></i>
                  <span>Orders</span>
               </a>
               <a href="admin_users.php">
                  <i class="ph-file-text"></i>
                  <span>Users</span>
               </a>
               <a href="admin_contacts.php">
                  <i class="ph-globe"></i>
                  <span>Messages</span>
               </a>
               <a href=logout.php>
						<i>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" fill="none" stroke="currentColor"
							stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-log-out"
							viewBox="0 0 24 24">
							<defs />
							<path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
						</svg></i>
						<span>Logout</span>
					</a>
            </nav>
         </div>

         <div class="container">
         
         <div class="btn-container-add">
         <button onclick="openAddProductPopup()" class="add-btn">+ Tambahkan Produk</button>
         <section class="add-product-popup">
            <div class="popup-content">
               <form action="" method="post" enctype="multipart/form-data">
               <h3>Tambahkan Produk</h3>
                  <input type="text" name="name" class="box" placeholder="Masukkan nama buku" required>
                  <input type="number" min="0" name="price" class="box" placeholder="Masukkan harga buku" required>
                  <input type="text" name="tahun" class="box" placeholder="Masukkan tahun terbit" required>
                  <input type="text" name="penulis" class="box" placeholder="Masukkan nama penulis" required>
                  <input type="text" name="penerbit" class="box" placeholder="Masukkan nama penerbit" required>
                  <input type="text" name="kategori" class="box" placeholder="Masukkan kategori" required>
                  
                  <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
                  <div class="button-container">
                     <button type="submit" name="add_product" class="update-btn">Add</button>
                     <button type="button" onclick="closeAddProductPopup()" class="cancel-btn">Cancel</button>
                  </div>
               </form>
            </div>
         </section>
         </div>




         <section class="show-products">
            

            <div class="table-container">
            
               <table class="table1">
                  <thead>
                     <tr>
                     <th>ID Buku</th>
                     <th>Cover</th>
                     <th>Judul Buku</th>
                     <th>Harga</th>
                     <th>Tahun Terbit</th>
                     <th>Nama Penulis</th>
                     <th>Kategori</th>
                     <th>Tindakan</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                     while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                        ?>
                        <tr>
                           <td>
                           <?php echo $fetch_product['id']; ?>
                           </td>
                           <td>
                              <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="Product Image" class="small-image"> 
                           </td>
                           <td>
                           <?php echo $fetch_product['name']; ?>
                           </td>
                           <td>
                           <?php echo $fetch_product['price']; ?>
                           </td>
                           <td>
                           <?php echo $fetch_product['tahunTerbit']; ?>
                           </td>
                           <td>
                           <?php echo $fetch_product['namaPenulis']; ?>
                           </td>
                           <td>
                           <?php echo $fetch_product['kategori']; ?>
                           </td>
                           <td>
                           <a href="admin_products.php?delete=<?php echo $fetch_product['id']; ?>"
                              onclick="return confirm('Delete this product?');" class="delete-btn">Delete</a> / 
                              <a href="admin_products.php?update=<?php echo $fetch_product['id']; ?>" class="edit-btn">Edit</a>
                           </td>
                        </tr>
                        <?php
                     }
                     ;
                     ?>
                     </tbody>
                  </table>
               
            </div>
         </section>

         <section class="edit-product-form">

            <?php
               if(isset($_GET['update'])){
                  $update_id = $_GET['update'];
                  $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
                  if(mysqli_num_rows($update_query) > 0){
                     while($fetch_update = mysqli_fetch_assoc($update_query)){
            ?>
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
               <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
               <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
               <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
               <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
               <input type="text" name="update_tahun" value="<?php echo $fetch_update['tahunTerbit']; ?>" class="box" placeholder="Masukkan tahun terbit" required>
               <input type="text" name="update_penulis" value="<?php echo $fetch_update['namaPenulis']; ?>"class="box" placeholder="Masukkan nama penulis" required>
               <input type="text" name="update_penerbit" value="<?php echo $fetch_update['penerbit']; ?>"class="box" placeholder="Masukkan nama penerbit" required>
               <input type="text" name="update_kategori" value="<?php echo $fetch_update['kategori']; ?>"class="box" placeholder="Masukkan kategori" required>
               <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
               <div class="button-container">
                  <button type="submit" value="Update" name="update_product" class="update-btn">Update</button>
                  <button type="reset" value="Cancel" id="close-update" class="cancel-btn" onclick="location.href='admin_products.php';">Cancel</button>

               </div>

            </form>
            <?php
                  }
               }
               }else{
                  echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
               }
            ?>

         </section>

         </div>



      </div>
   </div>

   <!-- partial -->
   <script src='https://unpkg.com/phosphor-icons'></script>
   <script src="./tabel.js"></script>
   <script src="js/admin_script.js"></script>

</body>