<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>

<div class="lotteries index">
	<h2>My Awards</h2>

	<ul id="award-tabs" class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#play" role="tab" data-toggle="tab">Play</a></li>
		<li><a href="#win" role="tab" data-toggle="tab">Win</a></li>
		<li><a href="#deposits" role="tab" data-toggle="tab">Deposits</a></li>
		<li><a href="#items" role="tab" data-toggle="tab">Items</a></li>
		<li><a href="#special" role="tab" data-toggle="tab">Special</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane fade in active" id="play">
			<?php if(isset($awards['ticket'])){foreach ($awards['ticket'] as $award){ echo $this->element('Awards/AwardPanel', array("award" => $award, 'tab' =>'tab_play'));}} ?>
			<?php if(isset($awards['presence'])){foreach ($awards['presence'] as $award){ echo $this->element('Awards/AwardPanel', array("award" => $award, 'tab' =>'tab_play'));}} ?>
		</div>
		<div class="tab-pane fade" id="win">
			<?php if(isset($awards['win'])){foreach ($awards['win'] as $award){ echo $this->element('Awards/AwardPanel', array("award" => $award, 'tab' =>'tab_win'));}} ?>
		</div>
		<div class="tab-pane fade" id="deposits">
			<?php if(isset($awards['deposits'])){foreach ($awards['deposits'] as $award){ echo $this->element('Awards/AwardPanel', array("award" => $award, 'tab' =>'tab_deposits'));}} ?>
		</div>
		<div class="tab-pane fade" id="items">
			<?php if(isset($awards['items'])){foreach ($awards['items'] as $award){ echo $this->element('Awards/AwardPanel', array("award" => $award, 'tab' =>'tab_items'));}} ?>
		</div>
		<div class="tab-pane fade" id="special">
			<?php if(isset($awards['special'])){foreach ($awards['special'] as $award){ echo $this->element('Awards/AwardPanel', array("award" => $award, 'tab' =>'tab_special'));}} ?>
		</div>
	</div>

</div>
<script>
	$(document).ready(function() {
		$('#award-tabs a').click(function (e) {
			e.preventDefault()
			$(this).tab('show')
		})

		var hash = document.location.hash;
		var prefix = "tab_";
		if (hash) {
			$('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
		} 

		$('.nav-tabs a').on('shown.bs.tab', function (e) {
			window.location.hash = e.target.hash.replace("#", "#" + prefix);
		});
	});
</script>