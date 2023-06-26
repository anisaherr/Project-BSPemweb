<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:login.php');
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
				<section class="service-section">
					<div class="tiles">

						<article class="tile">
							<div class="tile-header">
								<i class="ph-lightning-light"></i>
								<h3>
									<span>Total Pembayaran Pending</span>
									<span></span>
								</h3>
								<?php
								$total_pendings = 0;
								$select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
								if (mysqli_num_rows($select_pending) > 0) {
									while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
										$total_price = $fetch_pendings['total_price'];
										$total_pendings += $total_price;
									}
								}
								?>
								<div class="hasil">
									<?php echo "Rp. ".$total_pendings; ?>
								</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-fire-simple-light"></i>
								<h3>
									<span>Total Pembayaran Berhasil</span>
									<span></span>
								</h3>
								<?php
								$total_completed = 0;
								$select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
								if (mysqli_num_rows($select_completed) > 0) {
									while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
										$total_price = $fetch_completed['total_price'];
										$total_completed += $total_price;
									}
								}
								?>
								<div class="hasil">
									<?php echo "Rp. ".$total_completed; ?>
								</div>
							</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>Total Pesanan</span>
									<span></span>
								</h3>
								<?php
								$select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
								$number_of_orders = mysqli_num_rows($select_orders);
								?>
								<div class="hasil">
									<?php echo $number_of_orders; ?>
								</div>
							</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>Total Produk Dijual</span>
									<span></span>
								</h3>
								<?php
								$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
								$number_of_products = mysqli_num_rows($select_products);
								?>
								<div class="hasil">
									<?php echo $number_of_products; ?>
								</div>
							</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-fire-simple-light"></i>
								<h3>
									<span>Total Akun Pembeli</span>
									<span></span>
								</h3>
								<?php
								$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
								$number_of_users = mysqli_num_rows($select_users);
								?>
								<div class="hasil">
									<?php echo $number_of_users; ?>
								</div>
							</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-lightning-light"></i>
								<h3>
									<span>Total Akun Admin</span>
									<span></span>
								</h3>
								<?php
								$select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
								$number_of_admins = mysqli_num_rows($select_admins);
								?>
								<div class="hasil">
									<?php echo $number_of_admins; ?>
								</div>
							</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-fire-simple-light"></i>
								<h3>
									<span>Total Akun</span>
									<span></span>
								</h3>
								<?php
								$select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
								$number_of_account = mysqli_num_rows($select_account);
								?>
								<div class="hasil">
									<?php echo $number_of_account; ?>
								</div>
							</div>
						</article>

						<article class="tile">
							<div class="tile-header">
								<i class="ph-fire-simple-light"></i>
								<h3>
									<span>Pesan Baru</span>
									<span></span>
								</h3>
								<?php
								$select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
								$number_of_messages = mysqli_num_rows($select_messages);
								?>
								<div class="hasil">
									<?php echo $number_of_messages; ?>
								</div>
							</div>
						</article>

					</div>
				</section>
			</div>

			<!-- partial -->
			<script src='https://unpkg.com/phosphor-icons'></script>
			<script src="./script.js"></script>

</body>
</html>