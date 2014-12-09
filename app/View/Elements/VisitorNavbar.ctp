<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-user">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php 
				echo $this->Html->link(
					'Want to play ? Click on register !', 
					array('controller' => 'users', 'action' => 'register'),
					array('class' => 'navbar-brand')
					);
					?>
		</div>
		<div class="navbar-collapse collapse navbar-user">
			<div class="nav navbar-nav navbar-right">
				

				<?php 
				echo $this->Html->link(
					'Register', 
					array('controller' => 'users', 'action' => 'register'),
					array('class' => 'btn btn-primary navbar-btn')
					);
					?>
				</div>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</div>