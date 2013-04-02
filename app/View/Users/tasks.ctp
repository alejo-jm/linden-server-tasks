<div class="panel panelTasks">
	<div class="loading invisible">Loading</div>
	<p class="text-center panelTitle">Your currents Tasks</p>
	<div class="task">
		<div class="row name">New task</div>
		<div class="row priority">Task priority</div>
		<div class="row due_date">Due date</div>
		<div class="row link">
			<a title="Create new task" class="create" href="javascript:{};"><img class="create" border="0" src="/img/create.png" title="" alt="" /></a>
		</div>
	</div>
	<?php if (isset($tasks)): ?>
		<?php foreach ($tasks as $key => $task): 
				$due_date = date( 'Y-m-d H:i:s', strtotime($task['due_date']) );
				$today = date("Y-m-d H:i:s", time());
				$class = (strtotime($today)>strtotime($due_date)) ? 'due_date_end' : '';
		?>
			<div class="task">
				<div class="<?php echo $class ?> row name"><?php echo strlen($task['name']) > 18 ? substr($task['name'], 0, 18).' ...' : $task['name'];  ?></div>
				<div class="<?php echo $class ?> row priority"><?php echo $task['Priority']['title'] ?></div>
				<div class="<?php echo $class ?> row due_date"><?php echo $task['due_date'] ?></div>
				<div class="<?php echo $class ?> row link">
					<a title="Edit task" class="edit" id="edit_<?php echo $task['id'] ?>" href="javascript:{};"><img id="edit_<?php echo $task['id'] ?>" class="edit" border="0" src="/img/edit.png" title="" alt="" /></a>
					<a title="Delete task" class="delete" id="del_<?php echo $task['id'] ?>" href="javascript:{};"><img id="edit_<?php echo $task['id'] ?>" class="delete" border="0" src="/img/delete.png" title="" alt="" /></a>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>