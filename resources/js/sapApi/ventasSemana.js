"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const ventasSemana = document.querySelector("#ventasSemana");

    const ventaSemanalValorTotal = document.querySelector(
        "#ventaSemanalValorTotal"
    );

    const options = {
        style: "currency",
        currency: "COP",
    };

    async function getData() {
        const url = "/api/ventasSemanales";
        try {
            const request = await fetch(url);
            const result = await request.json();
            constructResult(result);
        } catch (error) {
            console.error(error);
        }
    }

    function constructResult(datas) {
        let totalVentaSemanal = 0;

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

        const ordenado = Object.entries(resumenVentasSemana)
            .sort((a, b) => b[1].KCNT_REVENUE - a[1].KCNT_REVENUE)
            .reduce((acc, [key, value]) => {
                acc[key] = value;
                return acc;
            }, {});

        datas.forEach((data) => {
            const { KCNT_REVENUE } = data;

            totalVentaSemanal += parseFloat(KCNT_REVENUE);
        });

        const formateado = Number(totalVentaSemanal).toLocaleString(
            "es-CO",
            options
        );
        ventaSemanalValorTotal.textContent = formateado;

        graficaSemana(ordenado);
    }

    getData();

    /**
     *
     * @param {resumenVentasSemana} : Datos resumidos y concatenados de las diferentes ventas Semanales
     */

    function graficaSemana(ordenado) {
        let delayed;

        const data = ordenado;
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

        const chart = new Chart(ventasSemana, {
            type: "bar",
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
        }, 291000);
    }

    setInterval(getData, 300000);

    function destroyGrafica() {
        const chart = Chart.getChart(ventasSemana);
        chart.destroy();
    }
});
