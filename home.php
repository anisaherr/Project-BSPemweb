<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Berhasil ditambahkan!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Produk berhasil ditambahkan ke keranjang!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Unleash Your Imagination, Dive into Aesthetic Pages</h3>
      <p>
Books are a feast for the senses, inviting us into a world of visual and tactile delight. The weight of a book in our hands, the crispness of its pages, and the artistry of its cover design create an aesthetic experience that is truly enchanting. With each turn of the page, we embark on a journey where imagination takes flight, and words become works of art. Books, in their aesthetic glory, offer a gateway to a realm where beauty and storytelling intertwine, leaving a lasting impression on our hearts and minds.</p>
   </div>

</section>

<section class="products">

   <h1 class="title">Produk Terbaru</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <a href="detail.php">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      </a>
      <span style="color: white; font-weight: bold; font-size:20px"><?php echo $fetch_products['name']; ?></span>
      <div class="name" style="text-align: left; color: white"><?php 
      echo "Judul : ".$fetch_products['name']. "<br>"; 
      echo "Penulis : ".$fetch_products['namaPenulis']. "<br>";
      echo "Penerbit : ".$fetch_products['penerbit']. "<br>";
      echo "Kategori : ".$fetch_products['kategori']. "<br>";
      echo "Tahun Terbit : ".$fetch_products['tahunTerbit'];
      ?></div>
      <div class="price">Rp. <?php echo $fetch_products['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="tambah" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Muat Lebih Banyak</a>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>