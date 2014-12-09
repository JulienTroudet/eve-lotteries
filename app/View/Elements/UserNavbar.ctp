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
					<h1><?php echo $userGlobal['username']; ?></h1>
			</div>
			<div class="row nav navbar-nav navbar-right navbar-user-info">
					<div class="well col-md-6 col-sm-6">
						<p><?php echo number_format($userGlobal['wallet'],2); ?> <span class="badge">ISK</span></p>
						<p><?php echo number_format($userGlobal['tokens']); ?> <span class="badge">Points</span></p>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="btn-group-vertical btn-block">
							<button type="button" class="btn btn-block btn-success">Deposit ISK</button>
							<button type="button" class="btn btn-block btn-success">My Awards</button>
						</div>
					</div>
			</div>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</div>