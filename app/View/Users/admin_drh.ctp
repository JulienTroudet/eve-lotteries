<div id="wrapper">
    <?php
    if ($userGlobal['group_id'] == 3) {
        echo $this->element('AdminMenu', array());
    }
    ?>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="users index">
                <h2><?php echo __('Employees'); ?></h2>
                <div class="row">

                    <?php foreach ($users as $user): ?>

                        <div class="col-md-6 col-sm-6">
                            <div class="panel panel-default">
                                <div class="media panel-heading panel-heading-lottery">
                                    <p class="pull-left">
                                        <img src="https://image.eveonline.com/Character/<?php echo $user['User']['id']; ?>_128.jpg">
                                    </p>
                                    <div class="media-body">
                                        <h3 class="media-heading"><?php echo h($user['User']['eve_name']); ?></h3>
                                        <h4><?php echo h($user['Group']['name']); ?></h4>
                                        <p>Since: <?php echo CakeTime::niceShort(h($user['User']['created'])); ?></p>
                                    </div>
                                </div>
                                <div class="panel-body panel-lot">
                                    <?php if(($user['Group']['name'] == 'Admin' || $user['Group']['name'] == 'Manager') && isset($wages[$user['User']['id']])): ?>
                                        <p><?php echo __('Claims number: ').$nbWages[$user['User']['id']]['nb']; ?></p>
                                        <p><?php echo __('Claims value: ').number_format($wages[$user['User']['id']]['totalBrut']); ?></p>
                                        <p><?php echo __('Total Bonus: ').number_format(($wages[$user['User']['id']]['totalAmount']-$wages[$user['User']['id']]['totalBrut'])); ?></p>
                                    <?php endif ?>
                                    <?php if($user['Group']['name'] == 'Admin' || $user['Group']['name'] == 'Banker'): ?>
                                        <p><?php echo __('Banking number'); ?></p>
                                        <p><?php echo __('Banking value'); ?></p>
                                        <p><?php echo __('Total Bonus'); ?></p>
                                    <?php endif ?>

                                    <p class="actions">
                                        <?php echo $this->Html->link(__('View'), array('action' => 'view', 'admin' => true, $user['User']['id'])); ?>
                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $user['User']['id'])); ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>
            </div>
        </div>
    </div>

