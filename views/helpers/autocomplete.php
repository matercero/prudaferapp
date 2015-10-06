<?php

/* /app/views/helpers/autocomplete.php (using other helpers) */

class AutocompleteHelper extends AppHelper {

    var $helpers = array('Html', 'Form');

    function replace_select($model, $label = null, $required = false, $almacene_id = null) {
        $required_text = "";
        if ($required == true)
            $required_text = "required";
        $label_text = "";
        if (!empty($label))
            $label_text = $label;
        else
            $label_text = $model;
        if ($this->model())
            $field_id = $model . 'Id';
        else
            $field_id = strtolower($model) . '_id';
        $output = '
       <div class="autocompletador input select ' . $required_text . '">
            <label for="' . $this->model() . $model . 'Id">' . $label_text . '</label>'
                . $this->Form->input(strtolower($model) . '_id', array('type' => 'hidden')) .
                '<p><input id="autocomplete-' . $model . '" type="text" value="" autofocus="autofocus" /></p>
        </div>
        <script type="text/javascript">
               if($( "#autocomplete-' . $model . '" ).length != 0){
        var autocomplete_' . $model . ' = $( "#autocomplete-' . $model . '" ).autocomplete({';
        if (!empty($almacene_id)) {
            if ($model == 'Articuloref')
                $output .= 'source: "'.Configure::read('proyect_url')  . strtolower('Articulo') . 's/autocomplete/' . $almacene_id . '",';
            else
                $output .= 'source: "'.Configure::read('proyect_url')  . strtolower($model) . 's/autocomplete/' . $almacene_id . '",';
        } else {
            if ($model == 'Articuloref')
                $output .= 'source: "'.Configure::read('proyect_url')  . strtolower('Articulo') . 's/autocomplete",';
            else
                $output .= 'source: "'.Configure::read('proyect_url')  . strtolower($model) . 's/autocomplete",';
        }

        $output .= 'minLength: 3,
            select: function( event, ui ) {
                $(\'.autocompletador input[type="hidden"]\').val(ui.item.id);
                $(\'.autocompletador input[type="hidden"]\').change();
                if($(\'#ArticulosPresupuestosproveedorePrecioProveedor\').length != 0){
                    $(\'#ArticulosPresupuestosproveedorePrecioProveedor\').val(ui.item.ultimopreciocompra);
                }
                if($(\'#ArticulosTareaPrecioUnidad\').length != 0){
                    $(\'#ArticulosTareaPrecioUnidad\').val(ui.item.precio_sin_iva);
                }
                if($(\'#ArticulosTareasAlbaranesclientesreparacionePrecioUnidad\').length != 0){
                    $(\'#ArticulosTareasAlbaranesclientesreparacionePrecioUnidad\').val(ui.item.precio_sin_iva);
                }
                if($(\'#stock\').length != 0){
                    $(\'#stock\').html(ui.item.existencias);
                }
            }
        });';
        if ($model == 'Articulo')
            $output .= '
        autocomplete_' . $model . '.data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.label + " -- " + item.almacene +"</a>" )
            .appendTo( ul );
        };
    }
            </script>';
        else
            $output .= '
        autocomplete_' . $model . '.data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.label + "</a>" )
            .appendTo( ul );
        };
    }
            </script>';
        return $output;
    }

}

?>
