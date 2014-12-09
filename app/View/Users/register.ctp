
<div class="row">

<?php print_r($_SERVER['HTTP_EVE_TRUSTED']);

if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='No')
{
	echo 'NOT TRUSTED';
}

if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes')
{
	echo 'TRUSTED';
}

if(!isset($_SERVER['HTTP_EVE_TRUSTED']))
{
	echo 'NOT IGB';
}

?>

<div class="warn">Please add this address as a <a href="javascript:CCPEVE.requestTrust('http://<?php echo$_SERVER['HTTP_HOST'];?>')">trusted site</a> and then <a href="javascript:window.location.reload()">refresh</a> this page.</div>
	<div class="col-md-6 col-sm-12 col-md-offset-3">
	<h2>Account Registration :</h2>
		<?php echo $this->Form->create('User', array(
			'url' => array(
				'controller' => 'users',
				'action' => 'register'
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
				'type' => 'password'
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
				'type' => 'password'
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
				)
			);

		$optionsFormLogin = array(
			'label' => 'Register',
			'div' => false,
			'class' => 'btn btn-block btn-primary'
			);

		echo $this->Form->end($optionsFormLogin);
		?>
	</div>
</div>
