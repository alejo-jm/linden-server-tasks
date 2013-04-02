<div class="panel createTask">
	<div class="loading invisible">Loading</div>
	<p class="text-center panelTitle">Task edit / creation</p>
	<?php 
		echo $this->Form->create('Task');
		echo $this->Form->hidden('id');
		echo $this->Form->input('name', array('label'=>'', 'div'=>false, 'class'=>'input','placeholder'=>"Write task name",  'autofocus', 'required'));
		echo $this->Form->input('priority_id', array('label'=>'','div'=>false, 'class'=>'input select','empty'=>'Select priority...', 'required'));
		echo $this->Form->input('due_date', array('class'=>'input select many', 'div'=>false));
		echo $this->Form->end(array('class'=>'input small', 'div'=>false));
		echo $this->Form->input('back', array('id'=>'goback','type'=>'button', 'label'=>'', 'div'=>false, 'class'=>'input backbutton'));
	?>			
</div>