<div class="seriespedidosventas">
    <h2>
        <?php __('Serie de Pedidos de Venta'); ?>
        <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $seriespedidosventa['Seriespedidosventa']['id']), array('class' => 'button_link')); ?> 
        <?php echo $this->Html->link(__('Borrar', true), array('action' => 'delete', $seriespedidosventa['Seriespedidosventa']['id']), array('class' => 'button_link'), sprintf(__('¿Seguro que quieres borrar la serie # %s?', true), $seriespedidosventa['Seriespedidosventa']['serie'])); ?> 
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
        <?php echo $this->Html->link(__('Nueva Serie', true), array('action' => 'add'), array('class' => 'button_link')); ?> 
        <?php echo $this->Html->link(__('Ir a Configuración', true), array('controller' => 'configs', 'action' => 'edit', 1), array('class' => 'button_link')); ?> 
    </h2>
    <dl><?php
        $i = 0;
        $class = ' class="altrow"';
        ?>
        <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Id'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
            <?php echo $seriespedidosventa['Seriespedidosventa']['id']; ?>
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Serie'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
            <?php echo $seriespedidosventa['Seriespedidosventa']['serie']; ?>
        </dd>
    </dl>
</div>