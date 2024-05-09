$(document).ready(function(){
    //funció per carregar productes
    cargarProductos();
    //s'hi ha un canvvi en la categoria del producte...
    $('#categoria').change(function(){
        //...carregar el producte
        cargarProductos();
    });

    function cargarProductos(){
        //obtindrem el valor de la categoria
        var categoria = $('#categoria').val();
        //farem una consulta en AJAX per obtenir els productes de la categoria seleccionada
        $.ajax({
            url: 'productos_categoria.php',
            type: 'POST',
            data: {categoria: categoria},
            //si la consulta s'ha fet bé, que l'imprimeixi en productes la consulta
            success: function(response){
                $('#productos').html(response);
            }
        });
    }
});
