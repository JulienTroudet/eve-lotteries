<?php
//*
if($this->params['action'] != 'register'){
echo $this->Form->create(
	'User', 
	array(
		'url' => array(
			'controller' => 'users',
			'action' => 'login'
			),
		'class' => 'navbar-form navbar-right',
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
		'label' => '',
		)
	);
echo "&nbsp;";
echo $this->Form->password(
	'User.password',
	array(
		'div' => array(
			'class' => 'form-group'
			),
		'placeholder' => 'Password',
		'class' => 'form-control',
		'label' => '',
		)
	);
echo "&nbsp;";

echo $this->Form->input(
	'remember_me', 
	array(
		'type' => 'checkbox', 
		'label'=>false,
		'data-toggle'=>'tooltip',
		'data-placement'=>'bottom',
		'title'=>'Remember me',
		'class'=>'remember-me',
		'div' => array(
			'class' => 'checkbox'
			),
		)
	);

echo "&nbsp;";
$optionsFormLogin = array(
	'label' => 'Log in',
	'div' => false,
	'class' => 'btn btn-success'
	);





echo $this->Form->end($optionsFormLogin);
}
?>

<?php 

	?>

	<script>
		$('.remember-me').tooltip()
	</script>