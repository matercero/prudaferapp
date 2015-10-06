<?php

class ConfigsController extends AppController {

    var $name = 'Configs';

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid config', true));
            $this->redirect(array('action' => 'edit', 1));
        }
        if (!empty($this->data)) {
            if ($this->Config->save($this->data)) {
                $this->Session->setFlash(__('La configuración ha sido actualizada', true));
                $this->redirect(array('action' => 'edit', 1));
            } else {
                $this->flashWarnings(__('The config could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Config->read(null, $id);
            $tiposivas = $this->Config->Tiposiva->find('list');
            $series_albaranesventas = $this->Config->SeriesAlbaranesventa->find('list');
            $seriespresupuestosventas = $this->Config->Seriespresupuestosventa->find('list');
            $seriespedidosventas = $this->Config->Seriespedidosventa->find('list');
            $seriesfacturasventas = $this->Config->Seriesfacturasventa->find('list');
            $seriespedidoscompras = $this->Config->Seriespedidoscompra->find('list');
            $seriesalbaranescompras = $this->Config->Seriesalbaranescompra->find('list');
            $seriespresupuestoscompras = $this->Config->Seriespresupuestoscompra->find('list');
            $seriesfacturascompras = $this->Config->Seriesfacturascompra->find('list');
            $this->set('tiposivas', $tiposivas);
            $this->set('seriesAlbaranesventas', $series_albaranesventas);
            $this->set('seriespedidosventas', $seriespedidosventas);
            $this->set('seriespresupuestosventas', $seriespresupuestosventas);
            $this->set('seriesfacturasventas', $seriesfacturasventas);
            $this->set('seriespedidoscompras', $seriespedidoscompras);
            $this->set('seriesalbaranescompras', $seriesalbaranescompras);
            $this->set('seriespresupuestoscompras', $seriespresupuestoscompras);
            $this->set('seriesfacturascompras', $seriesfacturascompras);
        }
    }

}

?>