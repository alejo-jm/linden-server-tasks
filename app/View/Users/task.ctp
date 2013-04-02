<div class="tasks form">
<?php echo $this->Form->create('Task'); ?>
	<fieldset>
		<legend><?php echo __('Add Task'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label'=>'', 'placeholder'=>"Write task name",  'autofocus', 'required'));
		echo $this->Form->input('priority');
		echo $this->Form->input('due_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>