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
    $(".añadircarrito").click(function (event) {
        event.preventDefault(); // Evita el envío del formulario

        let form = $(this).closest("form"); // Encuentra el formulario al que pertenece el botón

        $("#alerta-carrito").removeClass("d-none").fadeIn();

        setTimeout(() => {
            $("#alerta-carrito").fadeOut();
            form.submit(); 
        }, 1500);
    });
    $(".cancelar").on("click", function () {
        var pedidoId = $(this).data("id"); 
        $("#cancelarForm input[name='pedido_id']").val(pedidoId); 
    });
});
