<div class="navbar-form navbar-right" role="form">
<a href="<?php echo $eveSSO_URL ?>authorize/?response_type=code&amp;redirect_uri=<?php echo $appReturnUrl ?>&amp;client_id=<?php echo $appEveId ?>&amp;scope=&amp;state=<?php echo $antiForgeryToken ?>"><?php echo $this->Html->image('EVE_SSO.png', array('alt' => 'Eve Login')); ?></a>
</div>

<script>
	$('.remember-me').tooltip()
</script>