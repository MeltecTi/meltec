'use strict';

document.addEventListener('DOMContentLoaded', () => {

    const formulario = {
        name: '',
        email: '',
        password: '',
        image: '',
    }

    // Campos del Formulario
    const formAll = document.querySelector('#formUsers');
    const nameField = document.querySelector('#nameUser');
    const emailField = document.querySelector('#emailUser');
    const passwordField = document.querySelector('#password');
    const cPasswordField = document.querySelector('#cpassword');
    const fileField = document.querySelector('#imgFile');
    const rolesField = document.querySelector('#roles');
    const _x_csrf_token = document.getElementsByName('_token');

    // Eventos 
    nameField.addEventListener('blur', validar);
    emailField.addEventListener('input', validar);
    passwordField.addEventListener('blur', validar);
    cPasswordField.addEventListener('blur', validar);
    fileField.addEventListener('change', validar);
    rolesField.addEventListener('change', validar);
    formAll.addEventListener('submit', sendData);


    emailField.addEventListener('blur', (e) => {
        const email = e.target.value.toLowerCase().trim();
        checkEmail(email, e.target.parentElement);
    })

    // Funciones de validacion

    function validar(e) {
        if (e.target.value.trim() === '') {
            alerta(` El campo ${e.target.dataset.field} es Obligatorio!!`, e.target.parentElement);
            formulario[e.target.id] = '';
            return;
        }

        if (e.target.dataset.field === 'Correo Electronico' && !validarEmail(e.target.value)) {
            alerta('El email No es Valido', e.target.parentElement);
            formulario[e.target.id] = '';
            return;
        }

        if (e.target.dataset.field === 'Contraseña' && !validarContraseña(e.target.value)) {
            Swal.fire({
                icon: 'warning',
                title: '¡Ten en cuenta!',
                text: 'La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.',
                toast: true,
            })
        }

        limpiarAlertas(e.target.parentElement);

        formulario[e.target.name] = e.target.value.trim().toLowerCase();
    }

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

    function limpiarAlertas(reference) {
        const alert = reference.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }

    function validarEmail(email) {
        const regex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        const result = regex.test(email);
        return result;
    }

    function validarContraseña(password) {
        const regex = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
        const result = regex.test(password);
        return result;
    }

    function sendData(e) {
        e.preventDefault();
        postDataForm(formulario);
    }


    // Funcion Asincrona
    async function postDataForm() {

        

        let dataform = new FormData();
        dataform.append('name', nameField.value);
        dataform.append('email', emailField.value);
        dataform.append('password', passwordField.value);
        dataform.append('image', fileField.files[0]);
        dataform.append('roles[]', rolesField.value);


        const url = `http://localhost:8000/home/usuarios`;

        try {

            const request = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': _x_csrf_token[0].value,
                },
                method: 'POST',
                body: dataform,
                mode: 'cors',
            });

            if (!request.ok) {
                throw {
                    status: request.status,
                    statusText: request.statusText,
                }
            }
            const result = await request.json();

            if (result.message === 'Creado') {
                Swal.fire({
                    icon: 'success',
                    title: 'Exito!!',
                    text: 'Usuario Registrado correctamente!',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.assign('http://localhost:8000/home/usuarios')
                    }
                })
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ocurrio un error! :(',
            })
        }
    }

    async function checkEmail(email, reference) {
        const url = `/api/usuarios/${email}`;
        const request = await fetch(url);
        const result = await request.json();

        if (result.message === 'error') {
            alerta('Este Email ya esta en uso', reference);
            return;
        }
    }
});