<div class="mecanicos">
    <h2>
        <?php __('Mecánicos'); ?>
        <?php echo $this->Html->link(__('Nuevo Mecánico', true), array('action' => 'add'), array('class' => 'button_link')); ?>
    </h2>
    <?php
    echo $form->create('', array('action' => 'search'));
    echo $form->input('Buscar', array('type' => 'text','placeholder'=>'Aun no funciona','readonly'=>true));
    echo $form->end('Buscar');
    ?>
    
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>	
    </p>
    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Nombre'); ?></th>
            <th><?php echo $this->Paginator->sort('DNI'); ?></th>
            <th><?php echo $this->Paginator->sort('Activo'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($mecanicos as $mecanico):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $mecanico['Mecanico']['nombre']; ?>&nbsp;</td>
                <td><?php echo $mecanico['Mecanico']['dni']; ?>&nbsp;</td>
                <td><?php echo $mecanico['Mecanico']['activo']==1? 'Sí': 'No'; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $mecanico['Mecanico']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $mecanico['Mecanico']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>	
    </p>
    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>