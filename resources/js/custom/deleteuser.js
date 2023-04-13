'use strict';


document.addEventListener('DOMContentLoaded', () => {

    const deleteUser = document.querySelectorAll('.formdelete');
    const _token = document.getElementsByName('_token');

    deleteUser.forEach(user => {
        const userValue = user.dataset.value
        user.addEventListener('submit', (e) => {
            e.preventDefault();
            deleteUserFunction(userValue);
        })
    });

    function deleteUserFunction(user) {
        const data = new FormData();
        data.append('id', user);
        const url = `${window.location.pathname}/${user}`;

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '¿Estas seguro que deseas eliminar este usuario?',
            text: "Esta accion no se podra deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {

                try {
                    const request = await fetch(url, {
                        headers: {
                            'X-CSRF-TOKEN': _token[0].value
                        },
                        method: 'DELETE',
                        body: data,
                        mode: 'cors',
                    })
                    const result = await request.json()
                    

                    if (!request.ok) {
                        throw new Error(result.message);
                    }

                    if (result.message === 'Delete') {
                        swalWithBootstrapButtons.fire(
                            'Borrado!',
                            'El usuario ha sido Borrado :(',
                            'success'
                        ).then((result) => {
                            if(result.isConfirmed){
                                window.location.reload();
                                return;
                            }
                        })
                        return;
                    }

                } catch (error) {
                    console.error(error)
                    swalWithBootstrapButtons.fire(
                        'Ups!!',
                        'Hubo un error al eliminar el usuario :(',
                        'error'
                    )
                }

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El usuario se ha salvado de una Muerte atroz :D',
                    'error'
                )
            }
        })


    }

});