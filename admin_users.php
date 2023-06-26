<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
  header('location:admin_users.php');
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

      <section class="users">
        <div class="table-container">
          <table class="table3">
            <thead>
              <tr>
                <th>ID Pengguna</th>
                <th>Username</th>
                <th>Email</th>
                <th>Tipe Pengguna</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
              while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                ?>
                <tr>
                  <td>
                    <?php echo $fetch_users['id']; ?>
                  </td>
                  <td>
                    <?php echo $fetch_users['name']; ?>
                  </td>
                  <td>
                    <?php echo $fetch_users['email']; ?>
                  </td>
                  <td style="color:<?php if ($fetch_users['user_type'] == 'admin') {
                    echo 'var(--orange)';
                  } ?>"><?php echo $fetch_users['user_type']; ?></td>
                  <td>
                    <a href="admin_users.php?delete=<?php echo $fetch_orders['id']; ?>"
                      onclick="return confirm('Delete this order?');" class="btn btn-delete">
                      <span class="mdi mdi-delete mdi-24px"></span>
                      <span class="mdi mdi-delete-empty mdi-24px"></span>
                      <span class="sr-only"></span>
                    </a>
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

    </div>
    <!-- partial -->
    <script src='https://unpkg.com/phosphor-icons'></script>

</body>

</html>

<script>

</script>