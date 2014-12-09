<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-user">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<span class="navbar-brand">Want to play ? Click on register !</span>
		</div>
		<div class="navbar-collapse collapse navbar-user">
			<div class="nav navbar-nav navbar-right">
				

				<?php 
				echo $this->Html->link(
					'Register', 
					array('controller' => 'users', 'action' => 'register'),
					array('class' => 'btn btn-block btn-primary navbar-btn')
					);
					?>
				</div>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</div>