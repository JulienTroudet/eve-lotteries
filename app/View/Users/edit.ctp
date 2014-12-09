
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


		$optionsFormLogin = array(
			'label' => 'Edit',
			'div' => false,
			'class' => 'btn btn-block btn-primary'
			);

		echo $this->Form->end($optionsFormLogin);
		?>
	</div>
	



	
</div>
