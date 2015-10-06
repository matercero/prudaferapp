<div class="familias view">
<h2><?php  __('Ficha de Familia');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $familia['Familia']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $familia['Familia']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descripción'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $familia['Familia']['descripcion']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Familia', true), array('action' => 'edit', $familia['Familia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Eliminar Familia', true), array('action' => 'delete', $familia['Familia']['id']), null, sprintf(__('¿Desea borrar la família %s?', true), $familia['Familia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Familias', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Familia', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
