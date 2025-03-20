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
    //ALERTSSSSS---------
    $(".añadircarrito").click(function (event) {
        event.preventDefault(); 

        let form = $(this).closest("form"); 

        $("#alerta-carrito").removeClass("d-none").fadeIn();

        setTimeout(() => {
            $("#alerta-carrito").fadeOut();
            form.submit(); 
        }, 1500);
    });
    $(".btn comprar").click(function (event) {
        event.preventDefault();

        let form = $(this).closest("form"); 

        $("#alerta-comprar").removeClass("d-none").fadeIn();

        setTimeout(() => {
            $("#alerta-comprar").fadeOut();
            form.submit(); 
        }, 1500);
    });
    $(".cancelar").on("click", function () {
        var pedidoId = $(this).data("id"); 
        $("#cancelarForm input[name='pedido_id']").val(pedidoId); 
    });
});
