$(document).ready(function() {
    // Cuando se abre el modal, obtener el ID del producto
    $('#borrarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // El botón que abre el modal
        var productoId = button.data('id'); // Obtener el ID del producto del atributo 'data-id'

        // Actualizamos el valor del campo oculto con el ID del producto
        $('#productoId').val(productoId);
    });
});
