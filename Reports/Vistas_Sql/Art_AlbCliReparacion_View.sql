Select articulos.ref As Referencia, articulos.nombre As Articulo, articulos_tareas.precio_unidad As precio_unidad, articulos_tareas.cantidadreal As cantidadreal, articulos_tareas_albaranesclientesreparaciones.cantidadreal As cantidadreal1, articulos_tareas_albaranesclientesreparaciones.cantidad As cantidad From (((articulos Join articulos_tareas_albaranesclientesreparaciones On articulos_tareas_albaranesclientesreparaciones.articulo_id = articulos.id) Join articulos_tareas On articulos_tareas.articulo_id = articulos.id) Join tareas_albaranesclientesreparaciones On tareas_albaranesclientesreparaciones.id = articulos_tareas_albaranesclientesreparaciones.tareas_albaranesclientesreparacione_id) Join albaranesclientesreparaciones On tareas_albaranesclientesreparaciones.albaranesclientesreparacione_id = albaranesclientesreparaciones.id