<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h3>Structure de la table</h3>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>id</th>
								<th>user_id</th>
								<th>type</th>
								<th>value</th>
								<th>isk_value</th>
								<th>eve_item_id</th>
								<th>created</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>int(11)</td>
								<td>int(11)</td>
								<td>varchar(255)</td>
								<td>varchar(255)</td>
								<td>decimal(20,2)</td>
								<td>int(11)</td>
								<td>datetime</td>
							</tr>
							<tr>
								<td>Contient l'ID de la ligne</td>
								<td>Id de l'utilisateur. à remmplacer par ? dans la requète</td>
								<td>Le type de stat</td>
								<td>la value contient un id qui se réfère au sujet de la stat</td>
								<td>valeur en isk de la stat pour tout ce qui est buy de tickets win ou encore dépot</td>
								<td>l'ID de l'item quand c'est pertinent</td>
								<td>le moment où à été créé la stat</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="articles form">
				<?php echo $this->Form->create('Award'); ?>
				<fieldset>
					<legend><?php echo __('Add Award'); ?></legend>
					<?php
					echo $this->Form->input('name', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('description', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('group', array(
						'options' => array(
							'ticket' => 'ticket', 
							'items' => 'items',
							'win' => 'win',
							'special' => 'special',
							'deposits' => 'deposits',
							'presence' => 'presence',
							),
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('order', array(
						'step' => '1',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('request', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('award_credits', array(
						'step' => '1000000',
						'max' => '500000000',
						'min' => '1000000',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('status', array(
						'options' => array('Active' => 'active', 'Inactive' => 'inactive'),
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
						?>
					</fieldset>
					<?php 
					$optionsFormLogin = array(
						'label' => 'Submit',
						'div' => false,
						'class' => 'btn btn-block btn-primary'
						);
						echo $this->Form->end($optionsFormLogin); ?>
					</div>
				</div>
			</div>
		</div>