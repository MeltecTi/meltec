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
                const { id, component, content } = resource;

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

                const inputContent = document.createElement("TEXTAREA");
                inputContent.classList.add("form-control");
                inputContent.setAttribute("style", "height: 10rem;");
                inputContent.textContent = content;

                tdInputContent.appendChild(inputContent);

                tr.appendChild(tdInputComponent);
                tr.appendChild(tdInputContent);
                tbody.appendChild(tr);
            });

            table.appendChild(tbody);
            modalBody.appendChild(table);
        }
    }

    async function sendInputUpdate(value, id) {

        const data = {
            'component' : value
        }

        const url = `/api/recursos/${id}`;

        try {
            const request = await fetch(url, {
                method: 'PATCH',
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                    "X-CSRF-TOKEN": _token,
                },
                body: JSON.stringify(data),
            });

            const result = await request.json();
            console.log(result);
        } catch (error) {
            console.log(error);
        }
    }

    function limpiarModal() {
        while (modalBody.firstChild) {
            modalBody.removeChild(modalBody.firstChild);
        }
    }
});
