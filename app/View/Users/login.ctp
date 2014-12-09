
<div class="row">
	<div class="col-md-6 col-sm-12 col-md-offset-3">
		<h2>Please Log in !</h2>
		<?php
		echo $this->Form->create('User', array(
			'url' => array(
				'controller' => 'users',
				'action' => 'login'
				),
			'role' => 'form'
			));
		echo $this->Form->input(
			'User.username',
			array(
				'div' => array(
					'class' => 'form-group'
					),
				'placeholder' => 'Username',
				'class' => 'form-control',
				'label' => 'Login',
				)
			);
		echo $this->Form->input(
			'User.password',
			array(
				'div' => array(
					'class' => 'form-group'
					),
				'placeholder' => 'Password',
				'class' => 'form-control',
				'label' => 'Password',
				)
			);
		$optionsFormLogin = array(
			'label' => 'Log in',
			'div' => false,
			'class' => 'btn btn-block btn-primary'
			);

		echo $this->Form->end($optionsFormLogin);
		?>
	</div>
	<div class="col-md-6 col-sm-12"></div>
</div>