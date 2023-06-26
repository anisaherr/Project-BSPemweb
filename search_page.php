<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};
$categories_list = mysqli_query($conn, "SELECT DISTINCT `kategori` FROM `products`");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .filter-category {
         padding:1rem 1rem;
         cursor: pointer;
         background-color: var(--purple);
         color:var(--white);
         font-size: 1.8rem;
         border-radius: .5rem;
      }
   </style>

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Halaman Pencarian</h3>
   <p> <a href="home.php">home</a> / Pencarian </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Cari judul buku.." class="box">
      <select name="category" class="filter-category">
         <option value="">Semua Kategori</option>
         <?php
            // Tampilkan opsi-opsi kategori dari tabel "categories"
            while ($row = mysqli_fetch_assoc($categories_list)) {
               $selected_category = false;
               if(isset($_POST['category']) && $_POST['category'] == $row['kategori']){
                  echo '<option value="' . $row['kategori'] . '" selected>' . $row['kategori'] . '</option>';
               }else {
                  echo '<option value="' . $row['kategori'] . '">' . $row['kategori'] . '</option>';
               }
            }
         ?>
         
      </select>
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>


<section class="products" style="padding-top: 0;">
   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $search_category = $_POST['category'];
         $select_products_query = "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'";
         
         if(!empty($search_category)){
            
               $select_products_query .= " AND kategori LIKE '$search_category'";
            
         }
         $select_products = mysqli_query($conn, $select_products_query) or die('query failed');
         
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
      <a href="detail.php">
      <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
      </a><br>
      <span style="color: black; font-weight: bold; font-size:20px"><?php echo $fetch_product['name']; ?></span>
      <div class="name" style="text-align: left;"><?php 
      echo "Judul : ".$fetch_product['name']. "<br>"; 
      echo "Penulis : ".$fetch_product['namaPenulis']. "<br>";
      echo "Penerbit : ".$fetch_product['penerbit']. "<br>";
      echo "Kategori : ".$fetch_product['kategori']. "<br>";
      echo "Tahun Terbit : ".$fetch_product['tahunTerbit'];
      ?></div>
      <div class="price">Rp. <?php echo $fetch_product['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
   <!-- <form action="" method="post" class="box">
      <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
      <input type="number"  class="qty" name="product_quantity" min="1" value="1">
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" class="btn" value="add to cart" name="add_to_cart">
   </form> -->
   <?php
            }
         }else{
            echo '<p class="empty">Buku Tidak ditemukan!</p>';
         }
      }else{
         echo '<p class="empty">Cari Buku!</p>';
      }
   ?>
   </div>
  

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>