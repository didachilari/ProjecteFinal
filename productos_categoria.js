$(document).ready(function(){
    cargarProductos();

    $('#categoria').change(function(){
        cargarProductos();
    });

    function cargarProductos(){
        var categoria = $('#categoria').val();
        
        $.ajax({
            url: 'productos_categoria.php',
            type: 'POST',
            data: {categoria: categoria},
            success: function(response){
                $('#productos').html(response);
            }
        });
    }
});
