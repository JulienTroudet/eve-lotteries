<div class="account index">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<ul id="wallet-tabs" class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#account-pane" role="tab" data-toggle="tab">My account</a></li>
				<li><a href="#edit-pane" role="tab" data-toggle="tab">Edit my account</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="account-pane">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-md-offset-2">
							<div class="media">
								<p class="pull-left">
									<img src="https://image.eveonline.com/Character/<?php echo $userGlobal['id']; ?>_128.jpg">
								</p>
								<div class="media-body">
									<h2 class="media-heading">EVE Name : <?php echo $userGlobal['eve_name']; ?></h2>
									<h3 class="media-heading">EVE id : <?php echo $userGlobal['id']; ?></h3>
									<h3 class="media-heading">Mail : <?php echo $userGlobal['mail']; ?></h3>
								</div>
							</div>
							<?php if(!$userGlobal['active']):?>
								<div class="alert alert-danger" role="alert">
									<h4>Email adress not verified</h4>
									<p>Your email adress has not benn verified. Without this verifications somes features cannot be used :</p>
									<ul>
										<li>Password recovery</li>
										<li>Sponsorship link</li>
									</ul>
									<p>Please check your email and click on the link sent after your registration. You can get a new verification email by clicking on this button :</p>
									<?php echo $this->Html->link('Send Mail', 
										array('controller' => 'users', 'action' => 'resend_activation_mail', 'admin' => false, 'plugin' => false),
										array('class' => 'btn btn-primary'));?>
									</div>
								<?php endif;?>
								<?php if($userGlobal['active']):?>
									<div class="well account-well">	
										<div class="input-group">
											<span class="input-group-addon">My sponsorship link</span>
											<input type="text" class="form-control" read-only value="<?php echo $this->Html->url(array('controller'=>'users','action'=>'register',md5($userGlobal['id'])), true) ?>">
										</div>
										<br/>
										<div class="alert alert-success" role="alert">
											<h4>What is this ?</h4>
											<p>This link allow you to sponsor one of your fellow EVE buddies. If a player use your link to register in our website, he will receive 10 millions EVE-Lotteries Credits and <strong>you will earn 5% of every deposit he will make on EVE-Lotteries</strong>. For example if he deposits 100 000 000 ISK in his wallet you will get 5 000 000 EVE-Lotteries Credits as a bonus in yours. Isn't it cool ?</p>
										</div>

										<p>Want a better looking Referal Link ? Try our <?php echo $this->Html->link('Link Makup Script', array('controller' => 'pages', 'action' => 'eve_link', 'admin' => false, 'plugin' => false));?></p>
									</div>
									<div class="well account-well">
										<h2>Sponsorship</h2>
										<div class="row">
											<?php foreach ($buddies as $key => $buddy): 
											echo $this->element('Account/SponsoredUser', array(
												"buddy" => $buddy,
												));
											endforeach;
											?>
										</div>
									</div>
								<?php endif;?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="edit-pane">
						<div class="row">
							<div class="col-md-6 col-sm-12 col-md-offset-3">
								<h2>Account modification :</h2>
								<?php echo $this->Form->create('User', array(
									'url' => array(
										'controller' => 'users',
										'action' => 'edit'
										),
									'role' => 'form'
									)); ?>


								<?php

								echo $this->Form->input(
									'password',
									array(
										'div' => array(
											'class' => 'form-group'
											),
										'placeholder' => 'Password',
										'class' => 'form-control',
										'label' => 'Password',
										'type' => 'password',
										'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
										)
									);

								echo $this->Form->input(
									'password_confirm',
									array(
										'div' => array(
											'class' => 'form-group'
											),
										'placeholder' => 'Password',
										'class' => 'form-control',
										'label' => 'Confirm Password (Only if you want to change your password)',
										'type' => 'password',
										'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
										)
									);

								echo $this->Form->input(
									'mail',
									array(
										'div' => array(
											'class' => 'form-group'
											),
										'placeholder' => 'email@email.com',
										'class' => 'form-control',
										'label' => 'New Mail',
										'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
										)
									);
								echo $this->Form->input(
									'mail_confirm',
									array(
										'div' => array(
											'class' => 'form-group'
											),
										'placeholder' => 'email@email.com',
										'class' => 'form-control',
										'label' => 'Confirm Mail',
										'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
										)
									);


								$optionsFormLogin = array(
									'label' => 'Edit',
									'div' => false,
									'class' => 'btn btn-block btn-primary'
									);

								echo $this->Form->end($optionsFormLogin);
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>