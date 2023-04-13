"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const auditions = document.querySelectorAll(".audition");
    const apiToken = document
        .querySelector('meta[name="api-token"]')
        .getAttribute("content");

    const modalBody = document.querySelector("#modalBody");

    auditions.forEach((audition) => {
        audition.addEventListener("click", () => {
            const data = audition.dataset.value;
            searchData(data);
        });
    });

    async function searchData(id) {
        const url = `/api/audition/${id}`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                },
            });

            if (!request.ok) {
                throw new Error("Error al obtener los datos de Auditoria");
            }

            const result = await request.json();
            if (result.message === "ok") {
                tableData(result.data, result.userResponse);
            }
        } catch (error) {
            console.log(error);
        }
    }

    function tableData(dataAudition, user) {
        limpiarModal();
        const {
            id,
            event,
            old_values,
            new_values,
            url,
            ip_address,
            created_at,
        } = dataAudition;
        const ol = document.createElement("OL");
        ol.classList.add("list-group");

        const liId = document.createElement("LI");
        liId.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liId.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Id</div>
                ${id}
            </div>
        `;

        const liUser = document.createElement("LI");
        liUser.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liUser.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Usuario</div>
                ${user}
            </div>
        `;

        const liEvent = document.createElement("LI");
        liEvent.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liEvent.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Evento Realizado</div>
                ${event}
            </div>
        `;

        const liOdl = document.createElement("LI");
        liOdl.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liOdl.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Datos anteriores</div>
                <div class="d-flex">
                    ${JSON.stringify(old_values, null, 2)}
                </div>
            </div>
        `;

        const liNew = document.createElement("LI");
        liNew.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liNew.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Nuevos Datos</div>
                <div class="d-flex">
                    ${JSON.stringify(new_values, null, 2)}
                </div>
            </div>
        `;

        const liUrl = document.createElement("LI");
        liUrl.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liUrl.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Url</div>
                ${url}
            </div>
        `;

        const liIp = document.createElement("LI");
        liIp.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liIp.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Dirección Ip</div>
                ${ip_address}
            </div>
        `;

        const liDate = document.createElement("LI");
        liDate.classList.add(
            "list-group-item",
            "d-flex",
            "justify-content-between",
            "align-items-start"
        );
        liDate.innerHTML = `
            <div class="ms-2 me-auto">
                <div class="fw-bold">Fecha de Cambio</div>
                ${new Date(created_at).toLocaleDateString("es-CO", {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                })}
            </div>
        `;

        ol.appendChild(liId);
        ol.appendChild(liUser);
        ol.appendChild(liEvent);
        ol.appendChild(liOdl);
        ol.appendChild(liNew);
        ol.appendChild(liUrl);
        ol.appendChild(liIp);
        ol.appendChild(liDate);
        modalBody.appendChild(ol);
    }

    function limpiarModal() {
        while (modalBody.firstChild) {
            modalBody.removeChild(modalBody.firstChild);
        }
    }
});
