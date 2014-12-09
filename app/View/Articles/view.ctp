<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="articles view">
				<h2><?php echo __('Article'); ?></h2>
				<dl>
					<dt><?php echo __('Title'); ?></dt>
					<dd>
						<?php echo h($article['Article']['title']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Body'); ?></dt>
					<dd>
						<?php echo h($article['Article']['body']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('User'); ?></dt>
					<dd>
						<?php echo $this->Html->link($article['User']['username'], array('controller' => 'users', 'action' => 'view', $article['User']['id'])); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Created'); ?></dt>
					<dd>
						<?php echo h($article['Article']['created']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Modified'); ?></dt>
					<dd>
						<?php echo h($article['Article']['modified']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('Edit Article'), array('action' => 'edit', $article['Article']['id'])); ?> </li>
					<li><?php echo $this->Form->postLink(__('Delete Article'), array('action' => 'delete', $article['Article']['id']), array(), __('Are you sure you want to delete # %s?', $article['Article']['id'])); ?> </li>
				</ul>
			</div>
		</div>
	</div>
</div>
