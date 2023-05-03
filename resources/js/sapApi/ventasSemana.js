"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const tituloVentasSemanal = document.querySelector("#tituloVentasSemanal");
    const ventasSemana = document.querySelector("#ventasSemana");
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

        datas.forEach((data) => {
            const { KCNT_REVENUE } = data;

            totalVentaSemanal += parseFloat(KCNT_REVENUE);
        });

        const formateado = Number(totalVentaSemanal).toLocaleString(
            "es-CO",
            options
        );
        tituloVentasSemanal.textContent = `Total de ventas de la semana: ${formateado}`;

        graficaSemana(resumenVentasSemana);
    }

    getData();

    /**
     *
     * @param {resumenVentasSemana} : Datos resumidos y concatenados de las diferentes ventas Semanales
     */

    function graficaSemana(resumenVentasSemana) {
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
                    backgroundColor: ["#4C9EFF", "#DC3545" , '#ee1ed0', '#724b0b', '#2d521d', '#e15346', '#4d0ed5', '#018611', '#1c8398', '#83de11'],
                },
            ],
        };

        const chart = new Chart(ventasSemana, {
            type: "bar",
            data: dataGrafica,
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
                responsive: true,          
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
        const chart = Chart.getChart(ventasSemana);
        chart.destroy();
    }
});
