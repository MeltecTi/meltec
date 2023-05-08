"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const SemanaAnterior = document.querySelector("#SemanaAnterior");
    const ventasSemanaAnterior = document.querySelector('#ventasSemanaAnterior');

    const options = {
        style: "currency",
        currency: "COP",
    };

    async function getData() {
        const url = `/api/ventasSemanaAnteriorPasada`;
        try {
            const request = await fetch(url);
            const result = await request.json();
            constructResult(result);
        } catch (error) {
            console.error(error);
        }
    }

    function constructResult(datas) {
        let totalVentaSemanaAnterior = 0;

        /**
         * Obtener la sumatoria de todas las ventas al mes de los diferentes vendedores
         */

        const resumenVentasSemana = datas.reduce((acc, curr) => {
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

        datas.forEach((data) => {
            const { KCNT_REVENUE } = data;

            totalVentaSemanaAnterior += parseFloat(KCNT_REVENUE);
        });

        const formateado = Number(totalVentaSemanaAnterior).toLocaleString(
            "es-CO",
            options
        );

        SemanaAnterior.textContent = formateado;

        graficarSemana(resumenVentasSemana);
    }

    getData();

    /**
     *
     * @param {resumenVentasSemana} : Datos resumidos y concatenados de las diferentes ventas Semanales
     */

    function graficarSemana(resumenVentasSemana) {
        let delayed;

        const data = resumenVentasSemana;
        const labels = Object.keys(data);
        const values = Object.values(data).map((item) => item.KCNT_REVENUE);

        const dataGrafica = {
            labels: labels,
            datasets: [
                {
                    label: "Total Vendido",
                    data: values,
                    backgroundColor: [
                        "#4C9EFF",
                        "#DC3545",
                        "#ee1ed0",
                        "#724b0b",
                        "#2d521d",
                        "#e15346",
                        "#4d0ed5",
                        "#018611",
                        "#1c8398",
                        "#83de11",
                    ],
                },
            ],
        };

        const chart = new Chart(ventasSemanaAnterior, {
            type: "pie",
            data: dataGrafica,
            options: {
                responsive: false,
            },
        });

        /**
         * Retrazo para borrar la grafica
         */

        setTimeout(() => {
            destroyGrafica();
        }, 296000);
    }

    setInterval(getData, 300000);

    function destroyGrafica() {
        const chart = Chart.getChart(ventasSemanaAnterior);
        chart.destroy();
    }
});
