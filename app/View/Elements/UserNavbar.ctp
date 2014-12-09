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
			</div>
			<div class="nav navbar-nav navbar-right navbar-user-info">
				<div class="row">
					<?php
					$buttonDeposit = '';
					if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'){
						$buttonDeposit = '<a href="#" onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="The deposits made to EVE-Lotteries will be available at the next API check.">Deposit <span class="badge">ISK</span></a>';
					}
					else {
						$buttonDeposit = '<a onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="You must use the Ingame Browser to deposit ISK">Deposit <span class="badge">ISK</span></a>';
					}
					?>
					<div class="col-md-4 col-sm-4">
						<div class="well">
							<p><span id="wallet"><?php echo number_format($userGlobal['wallet'],2); ?></span> <i class="fa fa-money"></i></p>
							<p><span id="points"><?php echo number_format($userGlobal['tokens']); ?></span> <span class="badge">Points</span></p>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="btn-group-vertical btn-block">
							<div class="btn-group">
								<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
									My Wallet
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><?php echo $buttonDeposit; ?></li>
									<li><?php
										echo $this->Html->link(
											'My transactions',
											array('controller' => 'transactions', 'action' => 'index')										
											);
											?>
										</li>
									</ul>
								</div>
								<?php
								$label = 'Create lottery';
								if($nbFreeLotteries>0){
									$label= $label.' <span class="badge">'.$nbFreeLotteries.' Free';
								}
								
								echo $this->Html->link(
									$label, 
									'#collapse-item',
									array(
										'class' => 'btn btn-block btn-success new-lot-collapse',
										'data-toggle' => 'collapse',
										'escape' => false,
										)
									);
								
								echo $this->Html->link(
									$label, 
									array('controller' => 'lotteries', 'action' => 'index'),
									array(
										'class' => 'btn btn-block btn-success new-lot-redirect',
										'escape' => false,)
									);
									?>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="btn-group-vertical btn-block">

									<?php
									$label = 'My Lotteries';
									if($userGlobal['new_lot_won']>0){
										$label= $label.' <span class="badge">'.$userGlobal['new_lot_won'].' New';
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
										if($userGlobal['new_awards']>0){
											$label= $label.' <span class="badge">'.$userGlobal['new_awards'].' New';
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
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
						var pathname = window.location.pathname;
						if(pathname.slice(-1) == '/'){
							$('.new-lot-redirect').remove();
						}
						else{
							$('.new-lot-collapse').remove();
						}
					});
				</script>
