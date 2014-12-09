<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo '<h2>Want to play ? Log in with your EVE account !</h2>';}?>
</div>
<div class="articles index">
	<h2>News</h2>
	
	<?php foreach ($articles as $article): ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-12">
				<div class="panel panel-default panel-news">
					<div class="panel-body">
						<?php echo $article['Article']['body']; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	
	<div class="row">
		<div class="col-md-12">
			<ul class="pager">
				<li class="previous">
					<?php echo $this->Paginator->prev('Previous', array(), null, array('class' => 'prev disabled')); ?>
				</li>
				<li>
					<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
				</li>
				<li class="next">
					<?php echo $this->Paginator->next('Next', array(), null, array('class' => 'next disabled')); ?>
				</li>
			</ul>
		</div>
	</div>
