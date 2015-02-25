<div id="user-navbar">
	<?php echo $this->element('UserNavbar', array("userGlobal" => $userGlobal)); ?>
</div>
<div class="row">
	<div class="col-md-8 col-sm-12 col-md-offset-2">
		<h1>Get EVE Online beautifull links</h1>

		<p>Do you want to spam your referal link everywhere in New Eden ? That is cool but this link dont look very attractive.</p>
		<p>Here is the solution :</p>

		<ol>
			<li>Write the text you want to get as a link in the first text field.</li>
			<li>Select and right click to COPY the code that is in the third field</li>
			<li>Open your EVE notepad (In "Menu" => "Accessories") and PASTE what you copied inside</li>
			<li>Now you have a nice link to put everywhere !</li>
		</ol>

		<?php if(!$userGlobal['active']):?>
			<div class="alert alert-danger" role="alert">
				<h4>Email adress not verified</h4>
				<p>Your email adress has not benn verified. Without this verifications somes features cannot be used :</p>
				<ul>
					<li>Password recovery</li>
					<li>Sponsorship link</li>
				</ul>
				<p>Please check your email and click on the link sent after your registration. You can get a new verification email by clicking on this button :</p>
				<?php echo $this->Html->link('Send Mail', array('controller' => 'users', 'action' => 'resend_activation_mail', 'admin' => false, 'plugin' => false), array('class' => 'btn btn-primary'));?>
			</div>
		<?php endif;?>

		<?php if($userGlobal['active']):?>
			<form role="form">
				<div class="form-group">
					<label for="referalText">Text</label>
					<input class="form-control" id="referalText" placeholder="Your text here">
				</div>
				<div class="form-group">
					<label for="referalLink">Referal Link</label>
					<input class="form-control" id="referalLink" value="<?php echo $this->Html->url(array('controller'=>'users','action'=>'register',md5($userGlobal['id'])), true) ?>" readonly>
				</div>
				<div class="form-group">
					<label for="referalLinkToCopy">Referal Link to copy/paste</label>
					<input class="form-control" id="referalLinkToCopy" readonly>
				</div>
			</form>
		<?php endif;?>

		<br/>
		<br/>

		<p>Want to have more fun with links ? Our link makup scrip will help you :</p>
		<form role="form">
			<div class="form-group ">
				<label for="linkText">Text</label>
				<input class="form-control linkUrlHandsome" id="linkText">
			</div>
			<div class="form-group">
				<label for="linkUrl">URL</label>
				<input class="form-control linkUrlHandsome" id="linkUrl">
			</div>
			<div class="form-group">
				<label for="urlLinkToCopy">Referal Link</label>
				<input class="form-control" id="urlLinkToCopy" readonly>
			</div>
		</form>
	</div>
</div>

<script>

	$(document).ready(function() {


		$("#referalText").on('change keyup paste mouseup', function() {

			$("#referalLinkToCopy").val("<url="+$("#referalLink").val()+">"+$("#referalText").val()+"</url>");
		});

		$(".linkUrlHandsome").on('change keyup paste mouseup', function() {

			$("#urlLinkToCopy").val("<url="+$("#linkUrl").val()+">"+$("#linkText").val()+"</url>");
		});
	});

</script>