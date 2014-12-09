<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-user">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<p class="brand hidden-xs hidden-sm" style="margin-right:3px;"> <img src="https://image.eveonline.com/Character/<?php echo $userGlobal['id']; ?>_64.jpg"></p>
			<h2 class="brand hidden-md hidden-lg"> <?php echo $userGlobal['eve_name']; ?></h2>
		</div>
		<div class="navbar-collapse collapse navbar-user">
			<div class="nav navbar-nav hidden-xs hidden-sm">
				<h2><?php echo $userGlobal['eve_name']; ?></h2>
				<p>Next API Check : <?php echo $apiCheckTime; ?></p>
			</div>
			<div class="nav navbar-nav navbar-right navbar-user-info">
				<div class="row">
					<?php
					$buttonDeposit = '';
					if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'){
						$buttonDeposit = '<a href="#" onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="The deposits made to EVE-Lotteries will be available at the next API check."><i class="fa fa-plus-square"></i></a>';
					}
					else {
						$buttonDeposit = '<a onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="You must use the Ingame Browser to deposit ISK"><i class="fa fa-plus-square"></i></a>';
					}
					?>
					<div class="col-md-4 col-sm-4 col-user-navbar">
						<div class="well">
							<p><span id="wallet"><?php echo number_format($userGlobal['wallet'],2); ?></span> <i class="fa fa-money"></i> <?php echo $buttonDeposit; ?></p>
							<p><span id="points"><?php echo number_format($userGlobal['tokens']); ?></span> <span class="badge">Points</span></p>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-user-navbar">
						<div class="btn-group-vertical btn-block">
							<?php
							$label = 'My Wallet';
							echo $this->Html->link(
								$label, 
								array('controller' => 'transactions', 'action' => 'index'),
								array('class' => 'btn btn-block btn-success', 'escape' => false));
								?>
							<?php
							$label = 'My Messages';
							if($userGlobal['nb_new_messages']>0){
								$label= $label.' <span class="badge">'.$userGlobal['nb_new_messages'];
							}
							echo $this->Html->link(
								$label, 
								array('controller' => 'messages', 'action' => 'index'),
								array('class' => 'btn btn-block btn-success', 'escape' => false));
								?>
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-user-navbar">
							<div class="btn-group-vertical btn-block">

								<?php
								$label = 'My Lotteries';
								$nbWon = $userGlobal['nb_new_won_lotteries']+$userGlobal['nb_new_won_super_lotteries'];
								if($nbWon>0){
									$label= $label.' <span class="badge">'.$nbWon;
								}
								echo $this->Html->link(
									$label, 
									array('controller' => 'withdrawals', 'action' => 'index'),
									array(
										'class' => 'btn btn-block btn-primary',
										'escape' => false)
									);
									?>

									<?php
									$label = 'My Awards';
									if($userGlobal['nb_new_awards']>0){
										$label= $label.' <span class="badge">'.$userGlobal['nb_new_awards'];
									}
									echo $this->Html->link(
										$label, 
										array('controller' => 'awards', 'action' => 'index'),
										array(
											'class' => 'btn btn-block btn-primary',
											'escape' => false)
										);
										?>

									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-user-navbar">
									<?php
									$label = 'New lottery';
									if($nbFreeLotteries>0){
										$label= $label.'<br/> <span class="badge">'.$nbFreeLotteries.' Free';
									}

									echo $this->Html->link(
										$label, 
										'#collapse-item',
										array(
											'class' => 'btn btn-block btn-success new-lot-collapse btn-new-lot',
											'data-toggle' => 'collapse',
											'escape' => false,
											)
										);

									echo $this->Html->link(
										$label, 
										array('controller' => 'lotteries', 'action' => 'index', 'create'),
										array(
											'class' => 'btn btn-block btn-success new-lot-redirect btn-new-lot',
											'escape' => false,)
										);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
						var pathname = window.location.pathname;
						if(pathname.slice(-7) == 'little/' || pathname.slice(-6) == 'create'){
							$('.new-lot-redirect').remove();
						}
						else{
							$('.new-lot-collapse').remove();
						}
					});
				</script>
