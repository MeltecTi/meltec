"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const idchar = document.querySelector("#graficaid");

    const ventasHoyValorTotal = document.querySelector('#ventasHoyValorTotal');

    const listItemsData = document.querySelector("#listItemsData");

    const options = {
        style: "currency",
        currency: "COP",
    };

    async function getVentasMes() {
        const url = `/api/ventasDia`;

        try {
            const request = await fetch(url);
            const result = await request.json();
            constructTableResult(result);
            movimientsSalers(result);
        } catch (error) {
            console.error(error);
        }
    }

    function constructTableResult(datas) {
        let totalVenta = 0;

        /**
         * Obtener la sumatoria de todas las ventas al mes de los diferentes vendedores
         */

        const resumenVentasVendedor = datas.reduce((acc, curr) => {
            const vendedor = curr.TIP_SAL_EMP;

            if (acc[vendedor]) {
                acc[vendedor].KCNT_REVENUE += parseFloat(curr.KCNT_REVENUE);
            } else {
                acc[vendedor] = {
                    KCNT_REVENUE: parseFloat(curr.KCNT_REVENUE),
                };
            }

            return acc;
        }, {});

        /**
         * Posible informacion a plasmar
         */

        datas.forEach((data) => {
            const { KCNT_REVENUE } = data;

            totalVenta += parseFloat(KCNT_REVENUE);
        });

        /**
         * Total facturado del dia
         */

        const formateado = Number(totalVenta).toLocaleString("es-CO", options);
        ventasHoyValorTotal.textContent = Number(totalVenta).toLocaleString("es-CO", options);

        /**
         * Mostrar la grafica
         */

        graficaDiaria(resumenVentasVendedor);
    }

    function movimientsSalers(datas) {
        cleanList();
        datas.forEach((data) => {
            const { TIP_SAL_EMP, KCNT_REVENUE } = data;

            const li = document.createElement("LI");
            li.classList.add("list-group-item", "lis");

            const card = document.createElement("DIV");
            card.classList.add("card");

            const cardBody = document.createElement("DIV");
            cardBody.classList.add("card-body");

            const vendedorTitulo = document.createElement("H4");
            vendedorTitulo.textContent = TIP_SAL_EMP;

            const formatedValue = document.createElement("H5");
            formatedValue.textContent = Number(KCNT_REVENUE).toLocaleString(
                "es-CO",
                options
            );

            cardBody.appendChild(vendedorTitulo);
            cardBody.appendChild(formatedValue);

            card.appendChild(cardBody);

            li.appendChild(card);

            listItemsData.appendChild(li);
        });
    }

    getVentasMes();

    /**
     *
     * @param {resumenVentasVendedor} : Datos resumidos y concatenados de las diferentes ventas diaras
     */

    function graficaDiaria(resumenVentasVendedor) {
        let delayed;

        const data = resumenVentasVendedor;
        const labels = Object.keys(data);
        const values = Object.values(data).map((item) => item.KCNT_REVENUE);

        const valores = {
            labels: labels,
            datasets: [
                {
                    label: "Total Vendido",
                    data: values,
                    backgroundColor: ["#4C9EFF"],
                },
            ],
        }

        const chart = new Chart(idchar, {
            type: "bar",
            data: valores,
            options: {
                indexAxis: "y",
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (
                            context.type === "data" &&
                            context.mode === "default" &&
                            !delayed
                        ) {
                            delay =
                                context.dataIndex * 300 +
                                context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                responsive: false,
                plugins: {
                    legend: {
                        position: "top",
                    },
                    datalabels: {
                        aling: "end",
                        anchor: "end",
                        backgroundColor: (context) => {
                            return context.dataset.backgroundColor;
                        },
                        borderRadius: 4,
                        color: "white",
                        formatter: (value) => {
                            return value + " (100%)";
                        },
                    },
                },
            },
        });

        /**
         * Retrazo para borrar la grafica
         */

        setTimeout(() => {
            destroyGrafica();
        }, 296000);
    }

    setInterval(getVentasMes, 300000);

    function destroyGrafica() {
        const chart = Chart.getChart(idchar);
        chart.destroy();
    }

    function cleanList() {
        while (listItemsData.firstChild) {
            listItemsData.removeChild(listItemsData.firstChild);
        }
    }
});


