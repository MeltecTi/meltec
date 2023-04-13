"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const apiToken = document
        .querySelector('meta[name="api-token"]')
        .getAttribute("content");
    const _token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    obtenerCiudades();

    let ciudades = [];
    const listadoCiudades = document.querySelector("#listadoCiudades");
    const modalEditContent = document.querySelector("#modalEditContent");
    const contentCity = document.querySelector("#contentCity");
    const formNewCity = document.querySelector("#formNewCity");
    const loader3 = document.querySelector(".loader3");
    const loader2 = document.querySelector(".loader2");

    ClassicEditor.create(contentCity)
        .then((editor) => {
            editor.model.document.on("change:data", () => {
                const contenidos = contentCity;
                contenidos.value = editor.getData();
            });
        })
        .catch((error) => {
            console.log(error);
        });

    loader3.setAttribute("style", "display: none;");
    loader2.setAttribute("style", "display: none;");

    formNewCity.addEventListener("submit", (e) => {
        e.preventDefault();
        let data = new FormData();

        data.append("name", document.querySelector("#titleCity").value.trim());
        data.append("dataCity", contentCity.value);

        postNewCity(data);
    });
    // Funciones Asincronas

    async function postNewCity(data) {
        const url = `/api/city`;
        try {
            loader2.setAttribute(
                "style",
                "display: flex; justify-content: center;"
            );

            const request = await fetch(url, {
                headers: {
                    Authorization: "Bearer " + apiToken,
                    "X-CSRF-TOKEN": _token,
                },
                method: "POST",
                body: data,
                mode: "cors",
            });

            if (!request.ok) {
                throw new Error("Error al guardar los datos");
            }

            const result = await request.json();

            if (result.success) {
                loader2.setAttribute("style", "display: none;");
                Swal.fire({
                    icon: "success",
                    title: "Genial!!",
                    text: result.message,
                });
                obtenerCiudades();
            }

        } catch (error) {
            loader2.setAttribute("style", "display: none;");
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: error,
            });
        }
    }

    async function obtenerCiudades() {
        const url = `/api/city`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: "Bearer " + apiToken,
                },
            });

            const result = await request.json();

            if (!request.ok) {
                throw new Error(result.message);
            }

            ciudades = result.cities;
            mostrarCiudades();
        } catch (error) {
            console.error(error);
        }
    }

    async function getDataModalEdit(id) {
        const url = `/api/city/edit/${id}`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: "Bearer " + apiToken,
                },
            });

            const result = await request.json();
            if (result) {
                modalEdit(result);
            }

            if (!request.ok) {
                throw new Error(result.message);
            }
        } catch (error) {}
    }

    async function sendCambios(id, data) {
        const url = `/api/city/edit/${id}`;
        loader3.setAttribute(
            "style",
            "display: flex; justify-content: center;"
        );

        try {
            const request = await fetch(url, {
                headers: {
                    "X-CSRF-TOKEN": _token,
                    Authorization: "Bearer " + apiToken,
                },
                method: "POST",
                body: data,
                mode: "cors",
            });

            const result = await request.json();

            if (result.success) {
                loader3.setAttribute("style", "display: none;");

                Toastify({
                    text: result.message,
                    style: {
                        background: "#198754",
                    },
                    duration: 3000,
                }).showToast();

                obtenerCiudades();
            }
        } catch (error) {
            console.error(error);
            Toastify({
                text: error,
                style: {
                    background: "#f27474",
                },
                duration: 3000,
            }).showToast();
        }
    }

    function mostrarCiudades() {
        limpiarCiudades();

        if (ciudades.length === 0) {
            listadoCiudades.innerHTML = `
            <p class="lead text-center">
                No hay contenido para Mostrar
            </p>`;
        } else {
            const table = document.createElement("TABLE");
            table.classList.add("table", "table-hover");

            const thead = document.createElement("THEAD");
            const trhead = document.createElement("TR");

            trhead.innerHTML = `
                <th>Ciudad</th>
                <th>Descripción</th>
                <th>Opciones</th>
            `;

            const tbody = document.createElement("TBODY");
            ciudades.forEach((ciudad) => {
                const { id, name, dataCity } = ciudad;

                const tr = document.createElement("TR");
                const nameCity = document.createElement("TD");
                nameCity.textContent = name;

                const description = document.createElement("td");
                description.innerHTML = dataCity;

                const tdListadoOpciones = document.createElement("TD");
                const buttonEditar = document.createElement("BUTTON");
                buttonEditar.classList.add("btn", "btn-info");
                buttonEditar.setAttribute("data-bs-toggle", "modal");
                buttonEditar.setAttribute("data-bs-target", "#modalEdit");
                buttonEditar.setAttribute("data-value", id);
                buttonEditar.textContent = `Editar Rol`;
                buttonEditar.addEventListener("click", (e) => {
                    e.preventDefault();
                    getDataModalEdit(id);
                });

                tdListadoOpciones.appendChild(buttonEditar);

                tr.appendChild(nameCity);
                tr.appendChild(description);
                tr.appendChild(tdListadoOpciones);
                tbody.appendChild(tr);
            });

            thead.appendChild(trhead);
            table.appendChild(thead);
            table.appendChild(tbody);
            listadoCiudades.appendChild(table);
        }
    }

    function modalEdit(data) {
        limpiarModales();
        const { id, name, description } = data;

        // Header del modal
        const modalHeader = document.createElement("DIV");
        modalHeader.classList.add("modal-header");

        const titleHeaderModal = document.createElement("H1");
        titleHeaderModal.classList.add("modal-title", "fs-5");
        titleHeaderModal.setAttribute("id", "modalEdit");
        titleHeaderModal.textContent = `Editar Ciudad ${name}`;

        const buttonModalCerrar = document.createElement("BUTTON");
        buttonModalCerrar.classList.add("btn-close");
        buttonModalCerrar.setAttribute("data-bs-dismiss", "modal");
        buttonModalCerrar.setAttribute("aria-label", "Close");

        modalHeader.appendChild(titleHeaderModal);
        modalHeader.appendChild(buttonModalCerrar);

        // Contenido del modal
        const modalContent = document.createElement("DIV");
        modalContent.classList.add("modal-body");

        const formModalContent = document.createElement("FORM");

        // Formulario del modal
        const divTitle = document.createElement("DIV");
        divTitle.classList.add("form-floating", "mb-3");

        const titleFormEdit = document.createElement("INPUT");
        titleFormEdit.classList.add("form-control");
        titleFormEdit.setAttribute("id", "titleEdit");
        titleFormEdit.setAttribute("name", "title");
        titleFormEdit.value = name;

        const labelFormTitleEdit = document.createElement("LABEL");
        labelFormTitleEdit.setAttribute("for", "titleEdit");
        labelFormTitleEdit.textContent = `Ciudad`;

        divTitle.appendChild(titleFormEdit);
        divTitle.appendChild(labelFormTitleEdit);

        const contentModalEdit = document.createElement("DIV");
        contentModalEdit.classList.add("form-floating", "mb-3");

        const contentModal = document.createElement("TEXTAREA");
        contentModal.classList.add("form-control");
        contentModal.setAttribute("id", "content");
        contentModal.setAttribute("name", "content");
        contentModal.setAttribute(
            "style",
            "height: 250px; line-height: normal;"
        );
        contentModal.textContent = description;

        ClassicEditor.create(contentModal)
            .then((editor) => {
                editor.model.document.on("change:data", () => {
                    const contenidos = contentModal;
                    contenidos.value = editor.getData();
                });
            })
            .catch((error) => {
                console.log(error);
            });

        contentModalEdit.appendChild(contentModal);
        // contentModalEdit.appendChild(lavelContent);

        // Footer del modal

        const modalFooterEdit = document.createElement("DIV");
        modalFooterEdit.classList.add("modal-footer");

        const closeModalFooter = document.createElement("BUTTON");
        closeModalFooter.classList.add("btn", "btn-secondary");
        closeModalFooter.setAttribute("type", "button");
        closeModalFooter.setAttribute("data-bs-dismiss", "modal");
        closeModalFooter.textContent = `Cerrar`;

        const sendDataEdit = document.createElement("BUTTON");
        sendDataEdit.classList.add("btn", "btn-primary");
        sendDataEdit.setAttribute("type", "submit");
        sendDataEdit.textContent = `Enviar cambios`;

        modalFooterEdit.appendChild(closeModalFooter);
        modalFooterEdit.appendChild(sendDataEdit);

        modalContent.appendChild(divTitle);
        modalContent.appendChild(contentModalEdit);
        modalContent.appendChild(modalFooterEdit);

        formModalContent.appendChild(modalContent);

        // Evento del formulario
        formModalContent.addEventListener("submit", (e) => {
            e.preventDefault();

            const data = new FormData();
            data.append("name", titleFormEdit.value.trim());
            data.append("description", contentModal.value);

            sendCambios(id, data);
        });

        modalEditContent.appendChild(modalHeader);
        modalEditContent.appendChild(formModalContent);
    }

    // Funciones de limpieza de pantalla
    function limpiarCiudades() {
        while (listadoCiudades.firstChild) {
            listadoCiudades.removeChild(listadoCiudades.firstChild);
        }
    }

    function limpiarModales() {
        while (modalEditContent.firstChild) {
            modalEditContent.removeChild(modalEditContent.firstChild);
        }
    }
});
