"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const apiToken = document
        .querySelector('meta[name="api-token"]')
        .getAttribute("content");

    const _token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    let resouces = [];

    const resourcesWeb = document.querySelector("#resourcesWeb");
    const modalBody = document.querySelector("#modalBody");

    resourcesWeb.addEventListener("click", obtenerRecursos);

    async function obtenerRecursos() {
        const url = `/api/recursos`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                },
            });

            if (!request.ok) {
                throw new Error("Hubo un error al obtener los datos");
            }

            const result = await request.json();

            if (result.message === "ok") {
                resouces = result.data;
                console.log(resouces.length);
                mostrarDatos();
            }
        } catch (error) {
            limpiarModal();

            modalBody.innerHTML = `
            <div id="app">
                <div>403</div>
                <div class="txt">
                    Sin Autorizacion :(<span class="blink">_</span>
                </div>
            </div>
            `;
        }
    }

    async function sendInputUpdate(value, id) {
        const data = {
            component: value,
        };

        const url = `/api/recursos/${id}`;

        try {
            const request = await fetch(url, {
                method: "PATCH",
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                    "X-CSRF-TOKEN": _token,
                },
                body: JSON.stringify(data),
            });

            const result = await request.json();

            if (!request.ok) {
                throw new Error(result.message);
            }

            if (result.success) {
                Toastify({
                    text: result.message,
                    style: {
                        background: "#198754",
                    },
                    duration: 3000,
                }).showToast();
            }
        } catch (error) {
            Toastify({
                text: error.message,
                style: {
                    background: "red",
                },
                duration: 3000,
            }).showToast();
        }
    }

    async function sendContentUpdate(value, id) {
        const url = `/api/recursos/${id}`;

        const data = {
            content: value,
        };

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                    "X-CSRF-TOKEN": _token,
                },
                method: "PATCH",
                body: JSON.stringify(data),
                mode: "cors",
            });
            const result = await request.json();
            if (!request.ok) {
                throw new Error(result.message);
            }

            if (result.success) {
                Toastify({
                    text: result.message,
                    style: {
                        background: "#198754",
                    },
                    duration: 3000,
                }).showToast();
            }
        } catch (error) {
            Toastify({
                text: error.message,
                style: {
                    background: "red",
                },
                duration: 3000,
            }).showToast();
        }
    }

    async function sendSelectUpdate(value, id) {
        const url = `/api/recursos/${id}`;

        const data = {
            'type': value,
        };

        console.log(data);

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                    "X-CSRF-TOKEN": _token,
                },
                method: "PATCH",
                body: JSON.stringify(data),
                mode: "cors",
            });
            const result = await request.json();
            if (!request.ok) {
                throw new Error(result.message);
            }

            if (result.success) {
                Toastify({
                    text: result.message,
                    style: {
                        background: "#198754",
                    },
                    duration: 3000,
                }).showToast();
            }
        } catch (error) {
            Toastify({
                text: error.message,
                style: {
                    background: "red",
                },
                duration: 3000,
            }).showToast();
        }
    }

    function mostrarDatos() {
        limpiarModal();

        if (resouces.length === 0) {
            modalBody.innerHTML = `
            <div id="app">
                <div>Ups!!</div>
                <div class="txt">
                    Aqui no hay nada <span class="blink">_</span>
                </div>
                <div class="wrapper">
                    <div class="cloud">
                        <div class="cloud_left"></div>
                        <div class="cloud_right"></div>
                    </div>
                    <div class="rain">
                        <div class="drop"></div>
                        <div class="drop"></div>
                        <div class="drop"></div>
                        <div class="drop"></div>
                        <div class="drop"></div>
                    </div>
                    <div class="surface">
                        <div class="hit"></div>
                        <div class="hit"></div>
                        <div class="hit"></div>
                        <div class="hit"></div>
                        <div class="hit"></div>
                    </div>
                </div>
            </div>
            `;
        } else {
            const table = document.createElement("TABLE");
            table.classList.add("table", "table-hover", "table-bordered");

            const tbody = document.createElement("TBODY");
            resouces.forEach((resource) => {
                const { id, component, content, type_component } = resource;

                const tr = document.createElement("TR");
                const tdInputComponent = document.createElement("TD");

                //Input Flotante
                const divComponent = document.createElement("DIV");
                divComponent.classList.add("form-floating", "mb-3");

                const inputComponent = document.createElement("INPUT");
                inputComponent.classList.add("form-control");
                inputComponent.setAttribute("type", "text");
                inputComponent.setAttribute("id", "component");
                inputComponent.setAttribute("value", component.toUpperCase());

                // Evento blur para enviar cambios automaticamente
                inputComponent.addEventListener("blur", (e) => {
                    const data = e.target.value;
                    const sanit = encodeURIComponent(data).toLowerCase();
                    const idRequ = id;
                    sendInputUpdate(sanit, idRequ);
                });

                const labelComponent = document.createElement("LABEL");
                labelComponent.setAttribute("for", "component");
                labelComponent.textContent = "Componente";

                divComponent.appendChild(inputComponent);
                divComponent.appendChild(labelComponent);

                tdInputComponent.appendChild(divComponent);

                const tdInputContent = document.createElement("TD");

                const divComponentTextArea = document.createElement("DIV");
                divComponentTextArea.classList.add(
                    "form-floating",
                    "mb-3",
                    "col-10"
                );

                const inputContent = document.createElement("TEXTAREA");
                inputContent.classList.add("form-control");
                inputContent.textContent = content;

                ClassicEditor.create(inputContent)
                    .then((editor) => {
                        editor.model.document.on("change:data", () => {
                            const contenidos = inputContent;
                            contenidos.value = editor.getData();
                        });
                        editor.editing.view.document.on("blur", (e, data) => {
                            sendContentUpdate(editor.getData(), id);
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                divComponentTextArea.appendChild(inputContent);
                tdInputContent.appendChild(divComponentTextArea);

                // Evento blur cuando cambia el textarea

                inputContent.addEventListener("input", (e) => {
                    console.log(e);
                });

                const tdSelect = document.createElement("TD");
                const divSelect = document.createElement("DIV");

                // Crear el elemento select
                let select = document.createElement("select");
                select.classList.add("form-select", "col-3");
                select.setAttribute('value', type_component);
                

                // Crear las opciones
                let option1 = document.createElement("option");
                option1.value = '';
                option1.text = "Tipo de Dato";

                let option2 = document.createElement("option");
                option2.value = "url";
                option2.text = "Url o Red Social";

                let option3 = document.createElement("option");
                option3.value = "text";
                option3.text = "Texto con icono";

                // Agregar las opciones al select
                select.appendChild(option1);
                select.appendChild(option2);
                select.appendChild(option3);

                divSelect.appendChild(select);

                tdSelect.appendChild(divSelect);

                // Evento change en el Select
                select.addEventListener("change", (e) => {
                    const data = e.target.value;
                    const sanit = encodeURIComponent(data).toLowerCase();
                    sendSelectUpdate(sanit, id);
                });

                tr.appendChild(tdInputComponent);
                tr.appendChild(tdInputContent);
                tr.appendChild(tdSelect);
                tbody.appendChild(tr);
            });

            table.appendChild(tbody);
            modalBody.appendChild(table);
        }
    }

    function limpiarModal() {
        while (modalBody.firstChild) {
            modalBody.removeChild(modalBody.firstChild);
        }
    }
});
