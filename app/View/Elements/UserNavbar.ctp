<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-user">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<p class="brand hidden-xs hidden-sm"> <img src="https://image.eveonline.com/Character/<?php echo $userGlobal['eve_id']; ?>_64.jpg"></p>
			<h2 class="brand hidden-md hidden-lg"> <?php echo $userGlobal['username']; ?></h2>
		</div>
		<div class="navbar-collapse collapse navbar-user">
			<div class="nav navbar-nav hidden-xs hidden-sm">
				<div class="row navbar-user-info">
					<h1><?php echo $userGlobal['username']; ?></h1>
				</div>
			</div>
			<div class="nav navbar-nav navbar-right">
				<div class="row navbar-user-info">
					<div class="well col-md-6">
						
					</div>
					<div class="col-md-6">
						
					</div>
				</div>
			</div>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</div>