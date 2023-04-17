"use strict";
document.addEventListener("DOMContentLoaded", () => {
    let formulario = {
        name: "",
        phone: "",
        email: "",
        city: "",
        // mark: "",
        // industry: "",
        message: "",
    };

    const formContact = document.querySelector("#formContact");
    const loader = document.querySelector(".loader");

    const _token = document.querySelector('input[name="_token"]').value;
    const name = document.querySelector("#name");
    const phone = document.querySelector("#phone");
    const email = document.querySelector("#email");
    const city = document.querySelector("#city");
    const mark = document.querySelector("#mark");
    const industry = document.querySelector("#industry");
    const message = document.querySelector("#message");
    const btnSender = document.querySelector("#btnSender");

    name.addEventListener("blur", validar);
    phone.addEventListener("blur", validar);
    email.addEventListener("blur", validar);
    city.addEventListener("change", validarSelect);
    // mark.addEventListener("change", validarSelect);
    // industry.addEventListener("change", validarSelect);
    message.addEventListener("blur", validar);

    loader.setAttribute("style", "display: none;");

    formContact.addEventListener("submit", (e) => {
        e.preventDefault();

        if (!objNoVacio(formulario)) {
            alerta(
                "Todos los campos del formulario son requeridos",
                e.target.parentElement,
                "alert-danger"
            );
        } else {
            sendFormulario(formulario);
        }
    });

    async function sendFormulario(formulario) {
        const url = `/api/formulario`;
        loader.setAttribute("style", "display: flex; justify-content: center;");
        try {
            const request = await fetch(url, {
                headers: {
                    "X-CSRF-TOKEN": _token,
                    "Content-Type": "application/json",
                },
                method: "POST",
                body: JSON.stringify(formulario),
                mode: "cors",
            });

            if (!request.ok) {
                throw new Error(
                    "No se pudo enviar el mensaje ... Intenta de nuevo mas tarde o contacta con nosotros via Telefonica"
                );
            }

            const result = await request.json();

            if (result.success) {
                loader.setAttribute("style", "display: none;");
                limpiarAlertas(btnSender.parentElement);
                alerta(
                    result.message,
                    btnSender.parentElement,
                    "alert-success"
                );

                if (btnSender.parentElement.querySelector(".alert")) {
                    setTimeout(() => {
                        btnSender.parentElement.querySelector(".alert").remove();
                    }, 5500);
                }
            }
        } catch (error) {
            loader.setAttribute("style", "display: none;");
            limpiarAlertas(btnSender.parentElement);
            alerta(error, btnSender.parentElement, "alert-danger");

            if (btnSender.parentElement.querySelector(".alert")) {
                setTimeout(() => {
                    btnSender.parentElement.querySelector(".alert").remove();
                }, 5500);
            }
        }
    }

    function validar(e) {
        if (e.target.value.trim() === "") {
            alerta(
                `El campo ${e.target.dataset.name} es Obligatorio`,
                e.target.parentElement,
                "alert-danger"
            );
            return;
        }

        if (
            e.target.dataset.name === "Correo Electronico" &&
            !validarEmail(e.target.value)
        ) {
            alerta(
                "El email No es Valido",
                e.target.parentElement,
                "alert-danger"
            );
            return;
        }

        limpiarAlertas(e.target.parentElement);
        

        formulario[e.target.name] = e.target.value.trim().toLowerCase();
        
    }

    function validarSelect(e) {
        if (e.target.value === 0) {
            alerta(
                `El campo ${e.target.dataset.name} es Obligatorio`,
                e.target.parentElement,
                "alert-danger"
            );
            return;
        }

        limpiarAlertas(e.target.parentElement);

        formulario[e.target.name] = e.target.value;
        
    }

    function validarEmail(email) {
        const regex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        const result = regex.test(email);
        return result;
    }

    function objNoVacio(formulario) {
        for (let key in formulario) {
            if (
                formulario[key] === null ||
                formulario[key] === undefined ||
                formulario[key] === ""
            ) {
                return false;
            }
        }
        return true;
    }

    function alerta(message, reference, classColor) {
        limpiarAlertas(reference);

        const divError = document.createElement("DIV");
        divError.classList.add("alert", classColor, "mt-2");

        const msg = document.createElement("P");
        msg.textContent = message;
        msg.classList.add("text-center");

        divError.appendChild(msg);

        reference.appendChild(divError);
    }

    function limpiarAlertas(reference) {
        const alert = reference.querySelector(".alert");
        if (alert) {
            alert.remove();
        }
    }
});
