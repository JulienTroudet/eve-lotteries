<div id="user-navbar">
	<?php echo $this->element('UserNavbar', array("userGlobal" => $userGlobal)); ?>
</div>
<h1>Frequently asked questions</h1>

<h2>How do I deposit?</h2>

<p>Use the deposit button located under the "My Wallet" menu.

The countdown on the top of the site indicates when your EVE-Lotteries Wallet will be updated.

Updates are cleared every 30 minutes automatically through EVE's API.</p>

<h2>How can I get free Credits?</h2>
<p>There are two ways you can get free credits:
		<ul>
		<li>Complete the awards listed in the <?php echo $this->Html->link('"My Awards"', array('controller' => 'awards', 'action' => 'index', 'admin'=>false, 'plugin' => false));?> section. You need to fill some conditions to complete an award, but each will get you some shiny Credits.</li>
		<li>Get some of your friends to play on our site by using the buddy registration link. Under the section <?php echo $this->Html->link('"My Account"', array('controller' => 'users', 'action' => 'account', 'admin'=>false, 'plugin' => false));?> you will find a link witch allow your friends to subscribe with a 10 millions Credits bonus. On your side, every time they make an ISK deposit on EVE-Lotteries, you will be credited a bonus of 5% the amount of the transaction.</li>
		</ul>
</p>

<h2>How do I create an EVE-lottery?</h2>

<p>Use the <?php echo $this->Html->link('"New lottery"', array('controller' => 'lotteries', 'action' => 'index', 'admin'=>false, 'plugin' => false, 'create'));?> menu on top of this page.
A list of the available items will be displayed.
Then you can choose to buy a random ticket or choose to buy several at once. It will start a new EVE-Lottery with the Item.
You can't start a new lottery without buying at least one ticket.
</p>



<h2>How do I know when I win?</h2>

<p>The name of the winner will immediately be displayed on the bottom of the board under the "Last won lotteries"
Also check your <?php echo $this->Html->link('"My lotteries"', array('controller' => 'withdrawals', 'action' => 'index', 'admin'=>false, 'plugin' => false));?> menu, all your wins will be provided through this page.</p>



<h2>How do I claim my winning EVE-lotteries?</h2>

<p>Go to your <?php echo $this->Html->link('"My lotteries"', array('controller' => 'withdrawals', 'action' => 'index', 'admin'=>false, 'plugin' => false));?> menu and through the claims options.</p>
<ul>
<li>Get the value of your price + 5% by claiming EVE-lotteries credits</li>

<li>Get the value of your price to your EVE wallet by ISK claiming.</li>

<li>Get your price contracted on Jita by the Delivery claiming.</li>
</ul>