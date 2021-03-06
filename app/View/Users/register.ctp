
<div class="row">

	



	<?php if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='No'): ?>

		<div class="col-md-6 col-sm-12 col-md-offset-3">
			<div class="alert alert-danger" role="alert">
				<h3>Please add this address as a <a class="alert-link" href="javascript:CCPEVE.requestTrust('http://<?php echo$_SERVER['HTTP_HOST'];?>')">trusted site</a></h3>
				<p>Then <a class="alert-link" href="javascript:window.location.reload()">refresh</a> this page.</p>
			</div>
		</div>

		<div class="warn"></div>
	<?php endif;?>
	<?php if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'): ?>
		<div class="col-md-6 col-sm-12 col-md-offset-3">
			

			<h2>Account Registration :</h2>
			<img class="img-responsive center-block" src="https://image.eveonline.com/Character/<?php echo $_SERVER['HTTP_EVE_CHARID']; ?>_128.jpg">
			<?php echo $this->Form->create('User', array(
				'url' => array(
					'controller' => 'users',
					'action' => 'register',
					$sponsorCode
					),
				'role' => 'form'
				)); ?>


			<?php
			echo $this->Form->input(
				'username',
				array(
					'div' => array(
						'class' => 'form-group'
						),
					'placeholder' => 'Login',
					'class' => 'form-control',
					'label' => 'Login',
					'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
					)
				);

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
					'label' => 'Confirm Password',
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
					'label' => 'Mail',
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
				?>
				<div class="alert alert-info" role="alert">
				<p><strong>Why do we need your mail?</strong></p>
				<p>We wont give your informations to any third party web site. The only use for your mail is to get back a new password if you forgot the old one. We wont send you any newsletter or advertising. If you want, you can provide us a false e-mail adress. 
				</p>
				<p>After your ragistration a confirmation e-mail will be sent to you. You only have to confirm your adress if you want to get your referal link.</p>
				</div>
				<?php
			echo $this->Form->input(
				'display-id',
				array(
					'type' => 'text',
					'readonly' => 'readonly',
					'value' => $_SERVER['HTTP_EVE_CHARID'],
					'div' => array(
						'class' => 'form-group'
						),
					'class' => 'form-control',
					'label' => 'Your current EVE ID',
					'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
					)
				);

			echo $this->Form->input(
				'eve_name',
				array(
					'readonly' => 'readonly',
					'value' => $_SERVER['HTTP_EVE_CHARNAME'],
					'div' => array(
						'class' => 'form-group'
						),
					'class' => 'form-control',
					'label' => 'Your EVE name (will be displayed)',
					'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
					)
				);

				?>
				<?php if(isset($sponsor['User'])):?>
					<div class="well">
						<div class="media">
							<p class="pull-left">
								<img src="https://image.eveonline.com/Character/<?php echo $sponsor['User']['id']; ?>_64.jpg">
							</p>
							<div class="media-body">
								<h3 class="media-heading">Sponsor : <?php echo $sponsor['User']['eve_name']; ?></h3>
							</div>
						</div>
						<p>You will get <strong>10 000 000 EVE-Credits as a bonus</strong> for having a sponsor!</p>
					</div>
				<?php endif; ?>

				<?php
				$optionsFormLogin = array(
					'label' => 'Register',
					'div' => false,
					'class' => 'btn btn-block btn-primary'
					);

				echo $this->Form->end($optionsFormLogin);
				?>
			</div>
		<?php endif;?>
		<?php if(!isset($_SERVER['HTTP_EVE_TRUSTED']) || $_SERVER['HTTP_EVE_TRUSTED'] == ''): ?>
			<div class="col-md-6 col-sm-12 col-md-offset-3">
				<div class="alert alert-danger" role="alert">
					<h3>Please use the EVE-Online in game browser for registration !</h3>
					<p></p>
					<p style="text-align:center;">
						In game, open the Accessories Menu and click on this button : 
						<?php echo $this->Html->image('Accessories_menu.png', array('alt' => 'Accessories menu'));?>
					</p>
				</div>
			</div>
		<?php endif;?>
	</div>
