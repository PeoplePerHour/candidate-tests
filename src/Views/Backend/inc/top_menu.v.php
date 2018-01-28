<div class="top-menu">
	<ul class="nav navbar-nav pull-right">
		<li class="dropdown dropdown-user">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<span class="username username-hide-on-mobile"> <?= $_SESSION['panel']['username'] ?> </span>
				<i class="fa fa-angle-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-default">
				<li>
					<a href="<?= DOMAIN ?>/panel/logout">
						<i class="icon-key"></i> Log Out </a>
				</li>
			</ul>
		</li>
	</ul>
</div>