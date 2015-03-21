<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="EVE-Lotteries is a fresh new brand EVE Online gambling website !">
	<meta name="keywords" content="Gambling, EVE Online, EVE-Lotteries, Lottery, Lotteries, ISK, WIN ISK, Titan, PLEX"/>
	<?php echo $this->Html->meta( 'favicon.ico', 'img/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon'));?>

	<title>EVE-Lotteries.com - EVE Online Gambling Website</title>
	<?php echo $this->Html->css('../ckeditor/contents'); ?>
	<?php echo $this->Html->css('magic-bootstrap'); ?>
	<?php echo $this->Html->css('font-awesome.min'); ?>
	<?php echo $this->Html->css('toastr.min'); ?>
	<?php echo $this->Html->css('eve.lotteries4'); ?>

	
	<?php echo $this->fetch('css');?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min');?>
	<?php echo $this->Html->script('toastr.min'); ?>
	<?php echo $this->Html->script('number-format'); ?>
	<?php echo $this->Html->script('moment');?>
	<?php echo $this->Html->script('countdown.min');?>
	<?php echo $this->Html->script('moment-countdown.min'); ?>
	<?php echo $this->Html->script('tinysort.min'); ?>
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
						'FAQ', 
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
					<?php if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='No'): ?>
						<li>
							<a class="alert-link TrustModalButton" href="#">Join In Game Chat</a>
						</li>
					<?php elseif(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'): ?>
						<li>
							<a style="cursor:pointer;" onclick="CCPEVE.joinChannel('EVE-Lotteries')">Join In Game Chat</a>
						</li>
					<?php endif;?>
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

	<div class="visible-md visible-sm" style="padding-bottom:5em;">
	</div>

	<div class="container container-all" style="">

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

	</div> <!-- /container -->

	<div class="footer">
		<div class="container">
			<p class="text-muted">
				<i>EVE Online</i> and the EVE logo are the registered trademarks of <i>CCP hf.</i> All rights are reserved worldwide. All other trademarks are the property of their respective owners. <i>EVE Online</i>, the EVE logo, EVE and all associated logos and designs are the intellectual property of <i>CCP hf</i>. All artworks, screenshots, characters, vehicles, storylines, world facts or other recognizable features of the intellectual property relating to these trademarks are likewise the intellectual property of <i>CCP hf</i>. <i>CCP hf.</i> has granted permission to <i>EVE-Lotteries</i> to use <i>EVE Online</i> and all associated logos and designs for promotional and information purposes on its website but does not endorse, and is not in any way affiliated with, <i>EVE-Lotteries</i>. <i>CCP</i> is in no way responsible for the content on or functioning of this website, nor can it be liable for any damage arising from the use of this website.
			</p>
		</div>
	</div>


	<div class="modal fade" id="TrustModal" tabindex="-1" role="dialog" aria-labelledby="TrustModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="TrustModalLabel">Please trust our website !</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger" role="alert">
						<h3>Please add this address as a <a class="alert-link" href="javascript:CCPEVE.requestTrust('http://<?php echo$_SERVER['HTTP_HOST'];?>')">trusted site</a></h3>
						<p>Then <a class="alert-link" href="javascript:window.location.reload()">refresh</a> this page.</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


</body>
</html>

<script>
	$(document).ready(function() {
		$('.TrustModalButton').click(function(){
			window.scrollTo(0,0);
			CCPEVE.requestTrust('http://<?php echo$_SERVER['HTTP_HOST'];?>');
			$('#TrustModal').modal('show');

		});
	});
</script>