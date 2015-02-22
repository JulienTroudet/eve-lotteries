<?php if(isset($userGlobal)): ?>
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
					<?php if(!isset($_SERVER['HTTP_EVE_TRUSTED']) || $_SERVER['HTTP_EVE_TRUSTED'] == ''): ?>
						<p>Next API Check in <span class='countdown'></span></p>
					<?php endif;?>
					<?php if($_SERVER['HTTP_EVE_TRUSTED']=='Yes'): ?>
						<p>Next API Check in <?php 
							$datetime1 = new DateTime();
							$datetime2 = new DateTime($apiCheckTime);
							$interval = $datetime1->diff($datetime2);
							echo $interval->format('%i minutes %s seconds'); ?></p>
						<?php endif;?>
					</div>
					<div class="nav navbar-nav navbar-right navbar-user-info">
						<div class="row">

							<div class="col-md-4 col-sm-4 col-user-navbar">
								<div class="well">
									<p>
										<span id="wallet"><?php echo number_format($userGlobal['wallet'],2); ?></span> 
										<i class="fa fa-money"></i> 
										<a id="button-deposit" href="#" onclick="CCPEVE.showInfo(2, 98342107);"><i class="fa fa-plus-square"></i></a>
									</p>
									<p><span id="points"><?php echo number_format(floor($userGlobal['tokens'])); ?></span> <span class="badge">Points</span></p>
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
													$label= $label.'<br/> <span class="badge">'.$nbFreeLotteries.' Available';
												}
												if($this->params['controller'] == 'lotteries' && $this->params['action'] == 'index'){
													echo $this->Html->link(
														$label, 
														'#collapse-item',
														array(
															'class' => 'btn btn-block btn-success new-lot-collapse btn-new-lot',
															'data-toggle' => 'collapse',
															'escape' => false,
															)
														);
												}
												else{
													echo $this->Html->link(
														$label, 
														array('controller' => 'lotteries', 'action' => 'index_open'),
														array(
															'class' => 'btn btn-block btn-success new-lot-redirect btn-new-lot',
															'escape' => false,)
														);
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php else: ?>
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
							<?php endif; ?>

							<div class="modal fade" id="deposit-modal" tabindex="-1" role="dialog" aria-labelledby="deposit-modal-label" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="deposit-modal-label">Deposit ISK</h4>
										</div>
										<div class="modal-body">
											<div class="row" id="deposit-modal-body">
												<p>To get EVE-Lotteries credits you must log in the game with the character you used to register and give ISK to the <a id="button-deposit" href="#" onclick="CCPEVE.showInfo(2, 98342107);">EVE-Lotteries Corporation</a>. Once you have deposited any amount of ISK you have to wait until the EVE API refresh our datas to be credited with the same amount of EVE-Lotteries credits. </p>

												<div class="row">
													<div class="col-xs-12 col-md-12">
														<div class="center-block"><?php echo $this->Html->image('give_money.png', array('alt' => 'Give Money', 'class' => 'center-block'));?></div>
													</div>
													<div class="col-xs-12 col-md-12">
														<div class="center-block"><?php echo $this->Html->image('amount.png', array('alt' => 'Set Amount', 'class' => 'center-block'));?></div>
													</div>
												</div>
												<p>There is no need to provide a reason for the transfert.</p>
												<p>The new API check will take place in <span class='countdown'></span></p>
											</div>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>

							<script> 

								$(document).ready(function() {
									function CountDownTimer(dt, div_class)
									{	
										console.log(dt);
										var end = new Date(dt);
										console.log(end);
										var _second = 1000;
										var _minute = _second * 60;
										var _hour = _minute * 60;
										var _day = _hour * 24;
										var timer;

										function showRemaining() {
											var now = new Date();
											var distance = new Date(end - now);
											if (distance < 0) {

												clearInterval(timer);
												$('.'+div_class).html('any minute!');

												return;
											}
											var days = Math.floor(distance / _day);
											var hours = Math.floor((distance % _day) / _hour);
											var minutes = Math.floor((distance % _hour) / _minute);
											var seconds = Math.floor((distance % _minute) / _second);

											$('.'+div_class).html( minutes + ' minutes '+ seconds + ' seconds');
										}

										timer = setInterval(showRemaining, 1000);
									}

									CountDownTimer('<?php echo $apiCheckTime; ?>', 'countdown');

									$('#button-deposit').click(function(){

										window.scrollTo(0,0);


										$('#deposit-modal').modal('show');

									});
								});


</script>