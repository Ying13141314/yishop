$(document).ready(() => {

    $('.delete-producto').on('click', function (e) {
        e.preventDefault();
        const $me = $(this);

        Swal.fire({
            title: 'Vas a eliminar un producto de tu carrito',
            text: "¿Estás seguro de que quieres continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({
                data: { id: $me.data('id') },
                dataType: 'JSON',
                url: `/carrito/${$me.data('id')}`,
                method: 'DELETE',
                success: function (response) {
                    $('#subtotal').empty().html(response);

                    $me.parents('tr').first().remove();
                }
            });

        })
    })


})