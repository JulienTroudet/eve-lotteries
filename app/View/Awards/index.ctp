<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>

<div class="lotteries index">
	<h2>My Awards</h2>

	
	<div id="list-awards">
		<div class="row">
			<?php foreach ($awards as $award){ echo $this->element('Awards/AwardPanel', array(
			"award" => $award ));} ?>
		</div>		
	</div>

</div>