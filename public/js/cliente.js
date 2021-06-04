$(document).ready(() => {
    $('.botonEditCliente').show();

    $('.botonEditCliente').on('click', function () {
        $('.inputCliente').removeAttr('readonly');
    })

    $('.inputCliente').on('input', function () {
        $('.botonEditCliente').hide();
        $('.botonGuardarCliente').show()
    })

    $('.botonGuardarCliente').on('click', function () {
        const data = {
            nombre: $('.inputNombre').val(),
            apellidos: $('.inputApellidos').val(),
            email: $('.inputEmail').val(),
            password: $('.inputPassword').val(),
            telefono: $('.inputTelefono').val(),
            dni: $('.inputDni').val(),
            direccion: $('.inputDireccion').val(),
            codigo: $('.inputCodigoPostal').val(),
        }
        $.ajax({
            url: '/cliente/update',
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function (response) {
                $('.botonEditCliente').show();
                $('.botonGuardarCliente').hide();
                $('.inputCliente').each((index, el) => $(el).prop('readonly', true));
            }
        })
    })


    const $body = $('#modal-detalles-body');
    
    $('[data-dismiss="modal"]').click(function() {
        $('#modal-detalles').modal('hide');
    })

    $('.detalles-pedido').on('click', function (e) {
        e.preventDefault();

        const id = $(this).data('id');
        
        $.ajax({
            url: `/pedido/${id}/detalles`,
            type: 'GET',
            dataType: 'JSON',
            success: function (detalles) {

                if (!detalles) return;
                $body.empty();
                
                for (const detalle of detalles) {
                    $body.append(`<tr>`)

                    $body.append(`<td class="text-center">${detalle['nombre']}</td>`)
                    $body.append(`<td class="text-center">${detalle['cantidad']}</td>`)
                    $body.append(`<td class="text-center">${detalle['talla']}</td>`)

                    $body.append(`</tr>`)
                }
                
                
                $('#modal-detalles').modal('show');
            }
        })

    })



})