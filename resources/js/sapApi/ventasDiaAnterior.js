"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const diaAnterior = document.querySelector("#diaAnterior");

    const ventasHDiaAnteriorValorTotal = document.querySelector('#ventasHDiaAnteriorValorTotal');

    const options = {
        style: "currency",
        currency: "COP",
    };

    async function getDataDiaAnterior() {
        const url = "/api/ventasDiaAnterior";
        try {
            const request = await fetch(url);
            const result = await request.json();

            constructResult(result);
        } catch (error) {}
    }

    function constructResult(datas) {
        let totalVentaDiaAnterior = 0;

        /**
         * Obtener los datos totales de cada vendedor que ha vendido el dia anterior
         */

        const resumenVentasVendedorDiaAnterior = datas.reduce((acc, curr) => {
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
         * Arreglo para el total de venta del dia anterior
         */

        datas.forEach((data) => {
            const { KCNT_REVENUE } = data;

            totalVentaDiaAnterior += parseFloat(KCNT_REVENUE);
        });

        /**
         * Total de ventas al dia
         */

        const formatted = Number(totalVentaDiaAnterior).toLocaleString(
            "es-CO",
            options
        );
        ventasHDiaAnteriorValorTotal.textContent = formatted;

        graficaDiaAnterior(resumenVentasVendedorDiaAnterior);
    }

    getDataDiaAnterior();

    /**
     * Grafica para los datos concatenados
     */
    function graficaDiaAnterior(datosDiaAnterior) {
        let delayed;

        const data = datosDiaAnterior;
        const labels = Object.keys(data);
        const values = Object.values(data).map((item) => item.KCNT_REVENUE);

        
        const valores = {
            labels: labels,
            datasets: [
                {
                    label: "Total Vendido",
                    data: values,
                    backgroundColor: ["#DC3545"],
                },
            ],
        }
        
        const chart = new Chart(diaAnterior, {
            type: "bar",
            data: valores,
            options: {
                indexAxis : 'y',
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

    setInterval(getDataDiaAnterior, 300000);

    function destroyGrafica() {
        const chart = Chart.getChart(diaAnterior);
        chart.destroy();
    }
});
