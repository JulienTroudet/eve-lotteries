<div class="navbar-form navbar-right" role="form">
<a href="<?php echo $eveSSO_URL ?>authorize/?response_type=code&redirect_uri=<?php echo $appReturnUrl ?>&client_id=<?php echo $appEveId ?>&scope=&state=uniquestate123"><?php echo $this->Html->image('EVE_SSO.png', array('alt' => 'Eve Login')); ?></a>
</div>

<script>
	$('.remember-me').tooltip()
</script>