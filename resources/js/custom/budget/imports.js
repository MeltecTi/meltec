"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const apiToken = document
        .querySelector('meta[name="api-token"]')
        .getAttribute("content");

    const _token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const data = document.querySelector("#data");

    let budgets = [];

    getDataModel();

    async function getDataModel() {
        const url = `/api/budgets`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                },
            });

            if (!request.ok) {
                throw new Error("Error al obtener los datos de la tabla");
            }

            const result = await request.json();

            if (result.success) {
                budgets = result.data;
                viewData();
                console.log(budgets);
            }
        } catch (error) {
            clearData();
            console.log(error.message);
            data.innerHTML = `
            <div id="app">
                <div>403</div>
                <div class="txt">
                    ${error.message}<span class="blink">_</span>
                </div>
            </div>
            `;
        }
    }

    function viewData() {
        clearData();

        if (budgets.length === 0) {
            data.innerHTML = `<p>No hay datos para mostrar</p>`;
        } else {
            const table = document.createElement("TABLE");
            table.classList.add("table", "table-hover", "table-bordered");

            const thead = document.createElement("THEAD");
            thead.classList.add('text-center');
            thead.innerHTML = `
                <tr>
                    <th>Unidad de Negocio</th>
                    <th>Meta de la Unidad</th>
                    <th>Porcentaje de Meta</th>
                    <th>Meta por Director</th>
                    <th>Porcentaje</th>
                    <th>Meta de Comerciales</th>
                    <th>Porcentaje</th>
                    <th>Q1 %</th>
                    <th>Q2 %</th>
                    <th>Q3 %</th>
                    <th>Q4 %</th>
                    <th>Q1 $</th>
                    <th>Q2 $</th>
                    <th>Q3 $</th>
                    <th>Q4 $</th>
                    <th>Opciones</th>
                </tr>
            `;

            const tbody = document.createElement("TBODY");
            tbody.classList.add('text-center');
            budgets.forEach((budget) => {
                const { id, businessUnit, goal, goalPercent, goalDirector,  goalDirectorPercent, goalCommercial, commercialPercent, q1Percent, q2Percent, q3Percent, q4Percent, q1, q2, q3, q4 } = budget;

                const tr = document.createElement("TR");

                const tdBussinessUnit = document.createElement("TD");
                tdBussinessUnit.textContent = businessUnit;

                const tdGoal = document.createElement("TD");
                tdGoal.textContent = parseValue(goal);

                const tdGoalPercent = document.createElement('TD');
                tdGoalPercent.textContent = `${goalPercent} %`;

                const tdGoalDirector = document.createElement('TD');
                tdGoalDirector.textContent = parseValue(goalDirector);

                const tdGoalDirectorPercent = document.createElement('TD');
                tdGoalDirectorPercent.textContent = `${goalDirectorPercent} %`;

                const tdGoalCommercial = document.createElement('TD');
                tdGoalCommercial.textContent = parseValue(goalCommercial);

                const tdGoalCommercialPercent = document.createElement('TD');
                tdGoalCommercialPercent.textContent = `${commercialPercent} %`;

                const tdq1 = document.createElement('TD');
                tdq1.textContent = `${q1Percent} %`;

                const tdq2 = document.createElement('TD');
                tdq2.textContent = `${q2Percent} %`;

                const tdq3 = document.createElement('TD');
                tdq3.textContent = `${q3Percent} %`;

                const tdq4 = document.createElement('TD');
                tdq4.textContent = `${q4Percent} %`;

                const tdq1Value = document.createElement('TD');
                tdq1Value.textContent = parseValue(q1);
                
                const tdq2Value = document.createElement('TD');
                tdq2Value.textContent = parseValue(q2);
                
                const tdq3Value = document.createElement('TD');
                tdq3Value.textContent = parseValue(q3);
                
                const tdq4Value = document.createElement('TD');
                tdq4Value.textContent = parseValue(q4);

                const tdOpciones = document.createElement('TD');

                const divOpciones = document.createElement('DIV');
                divOpciones.classList.add('d-grid', 'gap-2', 'd-md-block');

                const editButton = document.createElement('A');
                editButton.classList.add('btn', 'btn-outline-info');
                editButton.innerHTML = `<i class="mdi mdi-lead-pencil"></i>`;
                editButton.setAttribute('href', `/home/budgets/${id}/edit`);

                const deleteButton = document.createElement('BUTTON');
                deleteButton.classList.add('btn', 'btn-outline-danger');
                deleteButton.innerHTML = `<i class="mdi mdi-delete-forever"></i>`;

                divOpciones.appendChild(editButton);
                divOpciones.appendChild(deleteButton);

                tdOpciones.appendChild(divOpciones);


                tr.appendChild(tdBussinessUnit);
                tr.appendChild(tdGoal);
                tr.appendChild(tdGoalPercent);
                tr.appendChild(tdGoalDirector);
                tr.appendChild(tdGoalDirectorPercent);
                tr.appendChild(tdGoalCommercial);
                tr.appendChild(tdGoalCommercialPercent);
                tr.appendChild(tdq1);
                tr.appendChild(tdq2);
                tr.appendChild(tdq3);
                tr.appendChild(tdq4);
                tr.appendChild(tdq1Value);
                tr.appendChild(tdq2Value);
                tr.appendChild(tdq3Value);
                tr.appendChild(tdq4Value);
                tr.appendChild(tdOpciones);
                tbody.appendChild(tr);
            });

            table.appendChild(thead);
            table.appendChild(tbody);
            data.appendChild(table);
        }
    }

    function parseValue(value) {
        const options = {
            style: "currency",
            currency: "COP",
        };

        const parse = parseFloat(value);
        const formatted = Number(parse).toLocaleString("es-CO", options);

        return formatted;
    }

    function clearData() {
        while (data.firstChild) {
            data.removeChild(data.firstChild);
        }
    }
});
