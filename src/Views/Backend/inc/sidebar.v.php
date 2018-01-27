<div class="page-sidebar-wrapper">
	<!-- END SIDEBAR -->
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
		<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
		<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
		<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="nav-item <?= $_SESSION['current_page'] == 'dashboard' ? 'active' : '' ?>">
				<a href="<?= DOMAIN ?>/panel" class="nav-link nav-toggle">
					<i class="icon-speedometer"></i>
					<span class="title">Dashboard</span>
				</a>
			</li>
			<li class="nav-item <?= $_SESSION['current_page'] == 'users' ? 'active' : '' ?>">
				<a href="<?= DOMAIN ?>/panel/users" class="nav-link nav-toggle">
					<i class="icon-users"></i>
					<span class="title">Users</span>
				</a>
			</li>
			<li class="nav-item ">
				<a href="<?= DOMAIN ?>/panel/clear-cache" class="nav-link nav-toggle">
					<i class="icon-close"></i>
					<span class="title">Clear Cache</span>
				</a>
			</li>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
	<!-- END SIDEBAR -->
</div>