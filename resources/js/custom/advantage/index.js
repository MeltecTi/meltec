'use strict';

document.addEventListener('DOMContentLoaded', () => {

    obtenerVentajas();

    let listas = [];

    // Declaracion de Variables

    const containerVentajas = document.querySelector('#listadoVentajas');
    const _token = document.querySelector('meta[name="csrf-token"]')
    const loader = document.querySelector('.loader');
    const form = document.querySelector('#formAdd');
    const dataTitle = document.querySelector('#titleAdv');
    const dataContent = document.querySelector('#contentAdv');
    const loader2 = document.querySelector('.loader2');
    const loader3 = document.querySelector('.loader3');
    const modalPather = document.querySelector('#modalEditContent');

    loader.setAttribute('style', 'display: none;');
    loader2.setAttribute('style', 'display: none;');
    loader3.setAttribute('style', 'display: none;');

    // funciones de escucha
    dataContent.addEventListener('blur', validar);
    dataTitle.addEventListener('blur', validar);
    form.addEventListener('submit', sendData);

    // Validador del formulario modal de Crear
    function validar(e) {
        if (e.target.value.trim() === '') {
            alerta(` El campo ${e.target.dataset.field} es Obligatorio!!`, e.target.parentElement);
            return;
        }
        limpiarAlertas(e.target.parentElement);
    }


    // Obtener los datos mediante FetchApi

    async function obtenerVentajas() {
        const url = `/api/ventajas`;

        try {
            const request = await fetch(url);
            const result = await request.json();

            listas = result;
            mostrarLista();

        } catch (error) {
            console.log(error);
        }
    }

    // Funcion asincrona para enviar los datos de una nueva Ventaja
    async function sendData(e) {

        e.preventDefault();
        let data = new FormData(this);
        const url = `/home/ventajas`;

        loader2.setAttribute('style', 'display: flex; justify-content: center;');

        const _token = data.get('_token');

        try {
            const request = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                method: 'POST',
                body: data,
                mode: 'cors',
            });

            if (!request.ok) {
                loader.style.display = 'none';
                throw {
                    status: request.status,
                    statusText: request.statusText,
                }

            }

            const result = await request.json();

            if (result.message === 'ok') {

                
                loader2.setAttribute('style', 'display: none;');
                Toastify({
                    text: "Ventaja Creada Correctamente",
                    style: {
                        background: '#198754'
                    },
                    duration: 3000,
                }).showToast();

                const ventajaObj = {
                    id: result.data.id,
                    title: result.data.title,
                    content: result.data.content,
                    created_at: result.data.created_at,
                    updated_at: result.data.updated_at
                }

                listas = [...listas, ventajaObj];
                document.querySelector('#staticBackdrop').setAttribute('data-bs-dismiss', 'modal');
                mostrarLista();

            }

        } catch (error) {
            loader2.setAttribute('style', 'display: none;');
            console.log(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ocurrio un error! :(',
            })
        }



    }

    // Mostrar la lista de los datos
    function mostrarLista() {
        limpiarVentajas();

        if (listas.length === 0) {
            const listadoEmpty = document.createElement('P')
            listadoEmpty.classList.add('lead', 'text-center');
            listadoEmpty.textContent = 'No hay Ventajas Creadas';

            containerVentajas.appendChild(listadoEmpty);
            return;
        }

        const table = document.createElement('TABLE');
        table.classList.add('table', 'table-hover')
        const thead = document.createElement('THEAD');
        thead.innerHTML = `
            <tr>
                <th>Titulo</th>
                <th>Resumen</th>
                <th>Fecha de Creación</th>
                <th>Opciones</th>
            </tr>
        `
        const tbody = document.createElement('TBODY');

        table.appendChild(thead);
        table.appendChild(tbody);
        listas.forEach(list => {

            const { id, title, content, created_at } = list

            const trListado = document.createElement('TR');

            const tdListadoTitulo = document.createElement('TD');
            tdListadoTitulo.textContent = title;

            const tdListadoResumen = document.createElement('TD');
            tdListadoResumen.textContent = `${content.slice(0, 50)}...`;

            const tdListadoFecha = document.createElement('TD');

            tdListadoFecha.textContent = new Date(created_at).toLocaleDateString('es-CO', {
                year: 'numeric', month: 'long', day: 'numeric'
            });

            const tdListadoOpciones = document.createElement('TD');

            // Boton de editar
            const urlEditar = document.createElement('BUTTON');
            urlEditar.classList.add('btn', 'btn-info');
            urlEditar.textContent = 'Editar Entrada';
            urlEditar.setAttribute('data-bs-toggle', 'modal');
            urlEditar.setAttribute('data-bs-target', '#modalEdit');
            urlEditar.setAttribute('dataValue', id);
            urlEditar.addEventListener('click', (e) => {
                e.preventDefault();
                getDataModalEdit(id);
            })

            tdListadoOpciones.appendChild(urlEditar);

            // Formulario Borrar
            const formBorrar = document.createElement('FORM');
            formBorrar.classList.add('deleteForm');
            formBorrar.setAttribute('data-value', id);
            formBorrar.setAttribute('style', 'display: inline;');
            formBorrar.onsubmit = function (e) {
                e.preventDefault();
                deleteFunction(id);
            };

            const buttonBorrar = document.createElement('INPUT');
            buttonBorrar.setAttribute('type', 'submit');
            buttonBorrar.classList.add('btn', 'btn-danger');
            buttonBorrar.setAttribute('value', 'Eliminar Ventaja');

            formBorrar.appendChild(buttonBorrar);
            tdListadoOpciones.appendChild(formBorrar);


            trListado.appendChild(tdListadoTitulo);
            trListado.appendChild(tdListadoResumen);
            trListado.appendChild(tdListadoFecha);
            trListado.appendChild(tdListadoOpciones);


            tbody.appendChild(trListado);
        });

        containerVentajas.appendChild(table)
    }

    // Funcion para borrar los registros

    async function deleteFunction(value) {
        const data = new FormData();
        data.append('id', value);
        const url = `${window.location.pathname}/${value}`;

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '¿Estas seguro que deseas eliminar esta Ventaja?',
            text: "Esta accion no se podra deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {

                loader.setAttribute('style', 'display: flex; justify-content: center;');

                try {
                    const request = await fetch(url, {
                        headers: {
                            'X-CSRF-TOKEN': _token.content
                        },
                        method: 'DELETE',
                        body: data,
                        mode: 'cors',
                    })

                    if (!request.ok) {
                        throw new Error('Error al eliminar el registro');
                    }

                    const result = await request.json();

                    if (result.message === 'ok') {
                        loader.setAttribute('style', 'display: none;');

                        Toastify({
                            text: `La ventaja ${value} Fue Borrada`,
                            style: {
                                background: '#198754'
                            },
                            duration: 3000,
                        }).showToast();

                        obtenerVentajas();
                    }

                } catch (error) {
                    loader.setAttribute('style', 'display: none;');
                    console.log(error);
                }

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                loader.setAttribute('style', 'display: none;');
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Operacion cancelada por el Usuario',
                    'error'
                )
            }
        })
    }

    // Funcion para obtener los datos del id
    async function getDataModalEdit(id) {
        const url = `/api/ventajas/edit/${id}`;
        
        try {
            const request = await fetch(url);

            if(!request.ok) {
                throw new Error('Error al obtener los datos');
                
            }

            const result = await request.json();
            modalEdit(result.data);

        } catch (error) {
            console.log(error)
        }
    }

    function modalEdit(result) {
        limpiarModales();
        const { id, title, content } = result;

        // Header del modal
        const modalHeader = document.createElement('DIV');
        modalHeader.classList.add('modal-header');

        const titleHeaderModal = document.createElement('H1');
        titleHeaderModal.classList.add('modal-title', 'fs-5');
        titleHeaderModal.setAttribute('id', 'modalEdit');
        titleHeaderModal.textContent = `Editar ventaja #${id}`;

        const buttonCloseModal = document.createElement('BUTTON');
        buttonCloseModal.classList.add('btn-close');
        buttonCloseModal.setAttribute('data-bs-dismiss', 'modal');
        buttonCloseModal.setAttribute('aria-label', 'Close');

        modalHeader.appendChild(titleHeaderModal);
        modalHeader.appendChild(buttonCloseModal);

        // Contenido del modal

        const modalContent = document.createElement('DIV');
        modalContent.classList.add('modal-body');

        const formModalContent = document.createElement('FORM');

        // Formulario del modal
        const divTitle = document.createElement('DIV');
        divTitle.classList.add('form-floating', 'mb-3');

        const titleFormEdit = document.createElement('INPUT');
        titleFormEdit.classList.add('form-control');
        titleFormEdit.setAttribute('id', 'titleEdit')
        titleFormEdit.setAttribute('name', 'title');
        titleFormEdit.value = title;

        const labelFormTitleEdit = document.createElement('LABEL');
        labelFormTitleEdit.setAttribute('for', 'titleEdit');
        labelFormTitleEdit.textContent = `Titulo de la entrada`;

        divTitle.appendChild(titleFormEdit);
        divTitle.appendChild(labelFormTitleEdit);

        const contentModalEdit = document.createElement('DIV');
        contentModalEdit.classList.add('form-floating', 'mb-3');

        const contentModal = document.createElement('TEXTAREA');
        contentModal.classList.add('form-control');
        contentModal.setAttribute('id', 'content');
        contentModal.setAttribute('name', 'content');
        contentModal.setAttribute('style', 'height: 250px; line-height: normal;');
        contentModal.textContent = content;

        const lavelContent = document.createElement('LABEL');
        lavelContent.setAttribute('for', 'content');
        lavelContent.textContent = `Contenido`;

        contentModalEdit.appendChild(contentModal);
        contentModalEdit.appendChild(lavelContent);

        // Footer del modal

        const modalFooterEdit = document.createElement('DIV');
        modalFooterEdit.classList.add('modal-footer');

        const closeModalFooter = document.createElement('BUTTON');
        closeModalFooter.classList.add('btn', 'btn-secondary');
        closeModalFooter.setAttribute('type', 'button');
        closeModalFooter.setAttribute('data-bs-dismiss', 'modal');
        closeModalFooter.textContent = `Cerrar`;

        const sendDataEdit = document.createElement('BUTTON');
        sendDataEdit.classList.add('btn', 'btn-primary');
        sendDataEdit.setAttribute('type', 'submit');
        sendDataEdit.textContent = `Enviar cambios`;

        modalFooterEdit.appendChild(closeModalFooter);
        modalFooterEdit.appendChild(sendDataEdit);

        modalContent.appendChild(divTitle);
        modalContent.appendChild(contentModalEdit);
        modalContent.appendChild(modalFooterEdit);

        
        formModalContent.appendChild(modalContent);

        // Evento del formulario
        formModalContent.addEventListener('submit', (e) => {
            e.preventDefault();

            const data = new FormData();
            data.append('title', (titleFormEdit.value.trim()) )
            data.append('content', (contentModal.value.trim()) )

            sendCambios(id, data);
        });

        modalPather.appendChild(modalHeader);
        modalPather.appendChild(formModalContent);

    }

    // Funcion asincrona para enviar datos
    async function sendCambios(id, data) {
        const url = `/api/ventajas/${id}`;
        loader3.setAttribute('style', 'display: flex; justify-content: center;');

        try {
            const request = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': _token.content,
                },
                method: 'POST',
                body: data,
                mode: 'cors'
            });
            
            if(!request.ok){
                throw new Error('Ocurrio un error al actualizar los datos');
            }

            const result = await request.json();

            if(result.message === 'ok') {
                loader3.setAttribute('style', 'display: none;');

                Toastify({
                    text: `La ventaja Fue actualizada correctamente`,
                    style: {
                        background: '#198754'
                    },
                    duration: 3000,
                }).showToast();

                obtenerVentajas();
            }
            
        } catch (error) {
            console.log(error)
        }
        return;
    }

    // Limpiar el html en tiempo real
    function limpiarVentajas() {
        while (containerVentajas.firstChild) {
            containerVentajas.removeChild(containerVentajas.firstChild)
        }
    }

    function limpiarModales() {
        while (modalPather.firstChild){
            modalPather.removeChild(modalPather.firstChild);
        }
    }

    // Mostrar la alerta del modal
    function alerta(message, reference) {

        limpiarAlertas(reference);

        const divError = document.createElement('DIV');
        divError.classList.add('alert', 'alert-danger', 'mt-2');

        const error = document.createElement('P');
        error.textContent = message;
        error.classList.add('text-center');

        divError.appendChild(error)

        reference.appendChild(divError);
    }

    // Limpiar las alertas del Modal
    function limpiarAlertas(target) {
        const alert = target.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }

});