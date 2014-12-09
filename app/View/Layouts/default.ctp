<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title><?php echo $title_for_layout; ?></title>

	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php echo $this->Html->css('font-awesome.min'); ?>
	<?php echo $this->Html->css('toastr.min'); ?>
	<?php echo $this->Html->css('eve.lotteries'); ?>
	

	<?php echo $this->fetch('css');?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min');?>
	<?php echo $this->Html->script('toastr.min'); ?>
	<?php echo $this->Html->script('number-format'); ?>
	<?php echo $this->fetch('script');?>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-top-right",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
	</script>
</head>

<body>

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-site">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo $this->webroot; ?>">EVE-Lotteries</a>
			</div>
			<p class="navbar-text">Next API Check : <?php echo $apiCheckTime; ?></p>
			<div class="navbar-collapse collapse navbar-site">
				<?php 
				if ($userGlobal != null) {
					echo $this->element('LogoutForm', array(
						"userGlobal" => $userGlobal
						));
				} 
				else{
					echo $this->element('LoginForm', array(
						"userGlobal" => $userGlobal
						));
				}
				?>
			</div><!--/.navbar-collapse -->
		</div>
	</div>

	<div class="container" style="margin-top:4em;">

		


		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

	</div> <!-- /container -->
	
	<div class="footer">
		<div class="container">
			<p class="text-muted">
				EVE Online and the EVE logo are the registered trademarks of CCP hf. All rights are reserved worldwide. All other trademarks are the property of their respective owners. EVE Online, the EVE logo, EVE and all associated logos and designs are the intellectual property of CCP hf. All artwork, screenshots, characters, vehicles, storylines, world facts or other recognizable features of the intellectual property relating to these trademarks are likewise the intellectual property of CCP hf. CCP hf. has granted permission to EVE-Lotteries to use EVE Online and all associated logos and designs for promotional and information purposes on its website but does not endorse, and is not in any way affiliated with, EVE-Lotteries. CCP is in no way responsible for the content on or functioning of this website, nor can it be liable for any damage arising from the use of this website.
			</p>
		</div>
	</div>

	
</body>
</html>
