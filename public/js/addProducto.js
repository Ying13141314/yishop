$(document).ready(() => {
    let talla ='';
    
    $('.tallaRopa').on('click', function (e) {
        e.preventDefault();
        talla = $(this).val()
        
    })
    $('.add-producto').on('click', function (e) {
        e.preventDefault();
        
        const productoId = $(this).data('id');
        $.ajax({
            data: {
                id: productoId,
                cantidad: 10,
                talla: talla
            },
            dataType: 'JSON',
            url: '/carrito',
            method: 'POST',
            success: function (response) {
                console.log(response)
            }
        });
        
    })
    
    
})