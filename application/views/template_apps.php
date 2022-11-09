<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<meta name="description" content="Portal Ujian PKN STAN">
	<meta name="author" content="farisz">
	<title><?= $this->config->item('nama_aplikasi') ?? 'Portal Ujian - PKN STAN' ?></title>
	<link rel="shortcut icon" href="<?= base_url('assets/favicon.ico'); ?>" type="image/x-icon">
	<!-- CSS files -->
	<link href="<?= base_url('assets/'); ?>css/tabler.min.css" rel="stylesheet" />
	<link href="<?= base_url('assets/'); ?>css/tabler-vendors.min.css" rel="stylesheet" />
	<link href="<?= base_url('assets/tabler-icons.min.css'); ?>" rel="stylesheet">
	<!-- Tabler Core -->
	<script src="<?= base_url('assets/'); ?>js/tabler.min.js" defer></script>
	<script src="<?= base_url('assets/'); ?>js/demo.min.js" defer></script>
	<script src="<?= base_url('assets/'); ?>js/demo-theme.min.js" defer></script>

</head>

<body>
	<div class="page">
		<?= $this->load->view('components/header', null, true); ?>
		<?= $this->load->view('components/navbar', null, true); ?>

		<div class="page-wrapper">
			<div class="page-body">
				<div class="container-xl">
					<!-- Content here -->
					<?= (show_alert()) ? show_alert() : ''; ?>
					<?php
					$this->load->view((!empty($page)) ? $page : 'pages/blank');
					?>
				</div>
			</div>
			<?= $this->load->view('components/footer', null, true); ?>
		</div>
	</div>
	<!-- Libs JS -->

	<script>
		var base_url = '<?= site_url(); ?>';

		function active_sidebar() {
			var url = window.location.href.split('?')[0];
			var sidenav = document.querySelector("#navbar-menu");
			var els = sidenav.querySelectorAll('a[href="' + url + '"]');
			if (url.split('/').length > base_url.split('/').length + 1 && els.length === 0) {
				var newUrl = url.slice(0, url.lastIndexOf('/'));
				var els = sidenav.querySelectorAll('a[href="' + newUrl + '"]');
			} else {
				var els = sidenav.querySelectorAll('a[href="' + url + '"]');
			}
			/* for (var i = 0, l = els.length; i < l; i++) {
				//els[i].classList.add("active");
				//var parent = els[i].parentNode.previousElementSibling;
				if (parent !== null && parent.classList.contains('dropdown-toggle')) {
					parent.classList.add("show");
					parent.ariaExpanded = true;
				}
				var submenu = els[i].closest(".dropdown-menu");
				if (submenu !== null) {
					submenu.classList.add("show");
				}
			} */
		}
		active_sidebar();
		var element = document.querySelector('.alert');
		if (element !== null && element.matches('.alert-dismissible')) {
			setTimeout(function() {
				bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert-dismissible")).close();
			}, 10000);
		}
		var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
		var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
			return new bootstrap.Popover(popoverTriggerEl)
		});

		function humanize(string) {
			return string.replace(/_/g, ' ').replace(/(^\w|\s\w)/g, firstCharOfWord => firstCharOfWord.toUpperCase());
		};
	</script>
	<?= !empty($js) ? $this->load->view($js, null, true) : ''; ?>
</body>

</html>