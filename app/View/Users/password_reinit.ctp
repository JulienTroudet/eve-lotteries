
<div class="row">

	<div class="col-md-6 col-sm-12 col-md-offset-3">
	<h2>Password recovery :</h2>
		<?php echo $this->Form->create('User', array(
			'url' => array(
				'controller' => 'users',
				'action' => 'password_reinit'
				),
			'role' => 'form'
			)); ?>


		<?php
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

		$optionsFormLogin = array(
			'label' => 'Send a mail',
			'div' => false,
			'class' => 'btn btn-block btn-primary'
			);

		echo $this->Form->end($optionsFormLogin);
		?>
	</div>
	



	
</div>
