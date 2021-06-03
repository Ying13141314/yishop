$(document).ready(() => {
    $('.botonEditCliente').show();
    
    $('.botonEditCliente').on('click',function (){
        $('.inputCliente').removeAttr('readonly');
    })
    
    $('.inputCliente').on('input', function(){
        $('.botonEditCliente').hide();
        $('.botonGuardarCliente').show()
    })
    
    $('.botonGuardarCliente').on('click',function(){
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
            url : '/cliente/update',
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
})