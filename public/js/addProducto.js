$(document).ready(() => {
    let talla ='';
    
    const conTalla = $('#con-talla').val();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
    })
    
    $('.tallaRopa').on('click', function (e) {
        e.preventDefault();
        
        $me = $(this);
        
        $('.tallaRopa').each(function (index, el) {
            if ($(this).val() === $me.val()) {
                $(this).removeClass('btn-light');
                $(this).addClass('btn-dark');
            } else {
                $(this).removeClass('btn-dark');
                $(this).addClass('btn-light');
            }
        });
        
        talla = $(this).val()
    })
    
    
    $('.add-producto').on('click', function (e) {
        e.preventDefault();
        
        if (conTalla && talla === '') {
            Toast.fire({
                icon: 'error',
                title: 'Tiene que seleccionar una talla'
            })
            
            return;
        }
        
        const productoId = $(this).data('id');
        
        $.ajax({
            data: {
                id: productoId,
                cantidad: 1,
                talla: talla
            },
            dataType: 'JSON',
            url: '/carrito',
            method: 'POST',
            success: function (response) {
                console.log(response);
            }
        });
        
    })
    
    
})