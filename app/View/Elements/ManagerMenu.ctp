<div id="sidebar-wrapper">
	<ul class="sidebar-nav">
		<li class="sidebar-brand">Manager Menu</li>
		<li>
            <?php $label = ''; ?>
            <?php if(isset($nbSuperClaimed) && $nbSuperClaimed>0): ?>
                <?php $label =  ' <span class="badge" style="display: inline;">'.$nbSuperClaimed.'</span>'; ?>
            <?php endif; ?>
            <?php echo $this->Html->link(__('Withdrawals List'.$label), array('controller' => 'withdrawals', 'action' => 'index', 'admin' => true), array('escape'=>false)); ?>
        </li>
        <li>
            <?php $label = ''; ?>
            <?php if(isset($nbSuperClaimed) && $nbSuperClaimed>0): ?>
                <?php $label =  ' <span class="badge" style="display: inline;">'.$nbSuperClaimed.'</span>'; ?>
            <?php endif; ?>
            <?php echo $this->Html->link(__('Give Wages'.$label), array('controller' => 'wages', 'action' => 'index', 'admin' => true), array('escape'=>false)); ?>
        </li>
		<li class="divider"></li>
		<li>
			<?php $label = ''; ?>
			<?php if(isset($nbSuperClaimed) && $nbSuperClaimed>0): ?>
				<?php $label =  ' <span class="badge" style="display: inline;">'.$nbSuperClaimed.'</span>'; ?>
			<?php endif; ?>
			<?php echo $this->Html->link(__('Give Won Super Lotteries'.$label), array('controller' => 'super_lotteries', 'action' => 'index', 'admin' => true), array('escape'=>false)); ?>
		</li>
		<li>
			<?php echo $this->Html->link(__('New Super Lottery'), array('controller' => 'super_lotteries', 'action' => 'add', 'admin' => true)); ?>
		</li>
		<li class="divider"></li>
		<li>
			<?php $label = ''; ?>
			<?php if(isset($nbFlashClaimed) && $nbFlashClaimed>0): ?>
				<?php $label =  ' <span class="badge" style="display: inline;">'.$nbFlashClaimed.'</span>'; ?>
			<?php endif; ?>
			<?php echo $this->Html->link(__('Give Won Flash Lotteries'.$label), array('controller' => 'flash_lotteries', 'action' => 'index', 'admin' => true), array('escape'=>false)); ?>
		</li>
		<li>
			<?php echo $this->Html->link(__('New Flash Lottery'), array('controller' => 'flash_lotteries', 'action' => 'add', 'admin' => true)); ?>
		</li>
		<li class="divider"></li>
		<li>
			<?php echo $this->Html->link(__('See transactions'), array('controller' => 'transactions', 'action' => 'index', 'admin' => true)); ?>
		</li>
	</ul>
</div>


