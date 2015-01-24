<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php echo $this->Html->meta( 'favicon.ico', 'img/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon'));?>

	<title>EVE-Lotteries</title>
	<?php echo $this->Html->css('../ckeditor/contents'); ?>
	<?php echo $this->Html->css('magic-bootstrap'); ?>
	<?php echo $this->Html->css('font-awesome.min'); ?>
	<?php echo $this->Html->css('toastr.min'); ?>
	<?php echo $this->Html->css('eve.lotteries'); ?>
	
	<?php echo $this->fetch('css');?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min');?>
	<?php echo $this->Html->script('toastr.min'); ?>
	<?php echo $this->Html->script('number-format'); ?>
	<?php echo $this->fetch('script'); ?>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script>
		$(document).ready(function() {
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
		};
	});
	</script>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
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
			
			
			<div class="navbar-collapse collapse navbar-site">
				
				<ul class="nav navbar-nav">
					<li><?php echo $this->Html->link(
						'F.A.Q.', 
						array('controller' => 'pages', 'action' => 'faq', 'admin'=>false, 'plugin' => false)
						);?>	
					</li>
					<li>
						<?php 
						$label = 'News';
						if($userGlobal['nb_unread_news']>0){
							$label= $label.' <span class="badge">'.$userGlobal['nb_unread_news'];
						}
						echo $this->Html->link($label, array('controller' => 'articles', 'action' => 'index', 'admin'=>false, 'plugin' => false), array('escape' => false));
						?>

					</li>
					<li>
						<?php echo $this->Html->link('Statistics', array('controller' => 'statistics', 'action' => 'index', 'admin'=>false, 'plugin' => false));?>	
					</li>
					<li>
						<a href="#" onclick="CCPEVE.joinChannel('EVE-Lotteries')">Join In Game Chat</a>
					</li>
				</ul>
				
				<?php 
				if ($userGlobal != null) {
					echo $this->element('LogoutForm', array(
						"userGlobal" => $userGlobal
						));
				} 
				else{
					echo $this->element('LoginForm', array("userGlobal" => $userGlobal));
				}
				?>
			</div><!--/.navbar-collapse -->
		</div>
	</div>



	<div class="container" style="margin-top:5em;margin-bottom: 12em;;">

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

	</div> <!-- /container -->

	<div class="footer">
		<div class="container">
			<p class="text-muted">
				EVE Online and the EVE logo are the registered trademarks of CCP hf. All rights are reserved worldwide. All other trademarks are the property of their respective owners. EVE Online, the EVE logo, EVE and all associated logos and designs are the intellectual property of CCP hf. All artworks, screenshots, characters, vehicles, storylines, world facts or other recognizable features of the intellectual property relating to these trademarks are likewise the intellectual property of CCP hf. CCP hf. has granted permission to EVE-Lotteries to use EVE Online and all associated logos and designs for promotional and information purposes on its website but does not endorse, and is not in any way affiliated with, EVE-Lotteries. CCP is in no way responsible for the content on or functioning of this website, nor can it be liable for any damage arising from the use of this website.
			</p>
		</div>
	</div>


</body>
</html>