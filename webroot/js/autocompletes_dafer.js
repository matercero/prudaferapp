function articuloFormatResult(articulo) {
    var markup = articulo.ref +" --- "+ articulo.nombre;
    return markup;
}

function articuloFormatSelection(articulo) {
    //console.log(articulo);
    return articulo.ref +" --- "+ articulo.nombre;
}
function maquinaFormatResult(maquina) {
    var markup = maquina.codigo +" --- "+ maquina.nombre;
    return markup;
}

function maquinaFormatSelection(maquina) {
    //console.log(maquina);
    return maquina.codigo +" --- "+ maquina.nombre;
}
function proveedoreFormatResult(proveedore) {
    var markup = proveedore.nombre;
    return markup;
}

function proveedoreFormatSelection(proveedore) {
    //console.log(maquina);
    return proveedore.nombre;
}
function clienteFormatResult(proveedore) {
    var markup = proveedore.nombre;
    return markup;
}

function clienteFormatSelection(cliente) {
    //console.log(maquina);
    return cliente.nombre;
}
    
$(document).ready(function() {
    $(".select_basico").select2({
        placeholder: "Seleccionar...",
        allowClear: true
    });
    $(".articulos_select").select2({
        placeholder: "Seleccionar un Articulo...",
        allowClear: true,
        minimumInputLength: 3,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: proyect_url()+"articulos/json_basico",
            dataType: 'json',
            data: function (term) {
                return {
                    q: term // search term
                };
            },
            results: function (data) { 
                return {
                    results: data.articulos
                };
            }
        },
        formatResult: articuloFormatResult, // omitted for brevity, see the source of this page
        formatSelection: articuloFormatSelection  // omitted for brevity, see the source of this page
    });
    $(".maquinas_select").select2({
        placeholder: "Selecciona una Maquina...",
        allowClear: true,
        minimumInputLength: 3,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: proyect_url()+"maquinas/json_basico",
            dataType: 'json',
            data: function (term) {
                return {
                    q: term // search term
                };
            },
            results: function (data) { 
                return {
                    results: data.maquinas
                };
            }
        },
        formatResult: maquinaFormatResult, // omitted for brevity, see the source of this page
        formatSelection: maquinaFormatSelection  // omitted for brevity, see the source of this page
    });
    $(".proveedores_select").select2({
        placeholder: "Selecciona un Proveedor...",
        allowClear: true,
        minimumInputLength: 3,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: proyect_url()+"proveedores/json_basico",
            dataType: 'json',
            data: function (term) {
                return {
                    q: term // search term
                };
            },
            results: function (data) { 
                return {
                    results: data.proveedores
                };
            }
        },
        formatResult: proveedoreFormatResult, // omitted for brevity, see the source of this page
        formatSelection: proveedoreFormatSelection  // omitted for brevity, see the source of this page
    });
    $(".clientes_select").select2({
        placeholder: "Selecciona un Cliente...",
        allowClear: true,
        minimumInputLength: 3,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: proyect_url()+"clientes/json_basico",
            dataType: 'json',
            data: function (term) {
                return {
                    q: term // search term
                };
            },
            results: function (data) { 
                return {
                    results: data.clientes
                };
            }
        },
        formatResult: clienteFormatResult, // omitted for brevity, see the source of this page
        formatSelection: clienteFormatSelection  // omitted for brevity, see the source of this page
    });
    
    
    
    $('button[type="reset"]').click(function(){
        $('.articulos_select').select2("data",null);
        $('.clientes_select').select2("data", null);
        $('.maquinas_select').select2("data", null);
        $('.proveedores_select').select2("data",null);
        $('.select_basico').select2("data",null);
        $('input[type=text]').val('');
        $('textarea').val('');
        return false;
    });
    
    
    /*Auto Serie*/
    $('#AlbaranesclienteSerie').change(function(){
        $.get(proyect_url()+'albaranesclientes/siguiente_numero_ajax/'+$(this).val(), function(data){
            $('#AlbaranesclienteNumero').val(parseInt(data));
        });
    })
    $('#AlbaranesclientesreparacioneSerie').change(function(){
        $.get(proyect_url()+'albaranesclientesreparaciones/siguiente_numero_ajax/'+$(this).val(), function(data){
            $('#AlbaranesclientesreparacioneNumero').val(parseInt(data));
        });
    })
    $('#PresupuestosclienteSerie').change(function(){
        $.get(proyect_url()+'presupuestosclientes/siguiente_numero_ajax/'+$(this).val(), function(data){
            $('#PresupuestosclienteNumero').val(parseInt(data));
        });
    })
});
