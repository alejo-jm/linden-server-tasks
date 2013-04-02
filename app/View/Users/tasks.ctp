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
		<?php foreach ($tasks as $key => $task): ?>
			<div class="task">
				<div class="row name"><?php echo strlen($task['name']) > 20 ? substr($task['name'], 0, 20).' ...' : $task['name'];  ?></div>
				<div class="row priority"><?php echo $task['Priority']['title'] ?></div>
				<div class="row due_date"><?php echo $task['due_date'] ?></div>
				<div class="row link">
					<a title="Edit task" class="edit" id="edit_<?php echo $task['id'] ?>" href="javascript:{};"><img id="edit_<?php echo $task['id'] ?>" class="edit" border="0" src="/img/edit.png" title="" alt="" /></a>
					<a title="Delete task" class="delete" id="del_<?php echo $task['id'] ?>" href="javascript:{};"><img id="edit_<?php echo $task['id'] ?>" class="delete" border="0" src="/img/delete.png" title="" alt="" /></a>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>