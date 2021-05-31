$(document).ready(() => {
    $('.botonEditCliente').show();
    
    $('.botonEditCliente').on('click',function (){
        console.log('hola')
        $('.inputCliente').removeAttr('readonly');
    })
    
    $('.inputCliente').on('change', function(){
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
        console.log(data);
        $.ajax({
            url : '/cliente/update',
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function (response) {
                $('.botonEditCliente').show();
                $('.botonGuardarCliente').hide()
            }
        })
    })
})