<?php if (isset($tasks)): ?>
	<div class="panel panelTasks">
		<?php foreach ($tasks as $key => $task): ?>
			<div class="task">
				<div class="row name"><?php echo $task['name'] ?></div>
				<div class="row priority"><?php echo $task['priority'] ?></div>
				<div class="row due_date"><?php echo $task['due_date'] ?></div>
			</div>
		<?php endforeach ?>
	</div>	
<?php endif ?>
