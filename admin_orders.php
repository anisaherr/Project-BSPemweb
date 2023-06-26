<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}


if (isset($_POST['update_order'])) {

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';

}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Gramedia Bookstore</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
   <link rel='stylesheet' href='https://cdn.materialdesignicons.com/3.6.95/css/materialdesignicons.min.css'>
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
               <a href=1adminpage.php>
                  <i class="ph-browsers"></i>
                  <span>Dashboard</span>
               </a>
               <a href=admin_products.php>
                  <i class="ph-check-square"></i>
                  <span>Products</span>
               </a>
               <a href=admin_orders.php>
                  <i class="ph-swap"></i>
                  <span>Orders</span>
               </a>
               <a href=admin_users.php>
                  <i class="ph-file-text"></i>
                  <span>Users</span>
               </a>
               <a href=admin_contacts.php>
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

         <div class="app-body-main-content">
            <section class="rekaporder">
               <div class="table-container">
                  <table class="table2">
                     <thead>
                        <tr>
                           <th>UserID</th>
                           <th>Placed On</th>
                           <th>Name</th>
                           <th>Number</th>
                           <th>Email</th>
                           <th>Address</th>
                           <th>Total Products</th>
                           <th>Total Price</th>
                           <th>Payment</th>
                           <th>Status</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                        if (mysqli_num_rows($select_orders) > 0) {
                           while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                              ?>
                              <tr>
                                 <td>
                                    <?php echo $fetch_orders['user_id']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['placed_on']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['name']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['number']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['email']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['address']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['total_products']; ?>
                                 </td>
                                 <td>Rp
                                    <?php echo $fetch_orders['total_price']; ?>
                                 </td>
                                 <td>
                                    <?php echo $fetch_orders['method']; ?>
                                 </td>
                                 <td>
                                    <form action="" method="post">
                                       <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                                       <div class="custom-select">
                                          <select name="update_payment">
                                             <option value="" selected disabled>
                                                <?php echo $fetch_orders['payment_status']; ?>
                                             </option>
                                             <option value="Pending">Pending</option>
                                             <option value="Completed">Completed</option>
                                          </select>
                                       </div>
                                       <input type="submit" value="Save" name="update_order" class="flat-button">
                                    </form>
                                 </td>
                                 <td>
                                    <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>"
                                       onclick="return confirm('Delete this order?');" class="btn btn-delete">
                                       <span class="mdi mdi-delete mdi-24px"></span>
                                       <span class="mdi mdi-delete-empty mdi-24px"></span>
                                       <span class="sr-only"></span>
                                    </a>
                                 </td>
                              </tr>
                              <?php
                           }
                        } else {
                           echo '<tr><td colspan="10" class="empty">No orders placed yet!</td></tr>';
                        }
                        ?>
                     </tbody>
                  </table>
               </div>
            </section>
         </div>


         <!-- partial -->
         <script src='https://unpkg.com/phosphor-icons'></script>
         <script src="./script.js"></script>

</body>

</html>