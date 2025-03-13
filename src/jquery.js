$(document).ready(function() {
    $('#borrarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // El botón que abre el modal
        var productoId = button.data('id'); // Obtener el ID del producto del atributo 'data-id'

        $('#productoId').val(productoId);
    });
    $('.sumarstock-btn').on('click', function() {
        var productoId = $(this).data('id');
        $('#productoIdSumar').val(productoId);
    });
    $('.restarstock-btn').on('click', function() {
        var productoId = $(this).data('id');
        $('#productoIdRestar').val(productoId);
    });
});
