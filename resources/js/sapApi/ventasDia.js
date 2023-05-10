"use strict";

document.addEventListener("DOMContentLoaded", () => {
    /**
     * Graficas Canva
     */
    const idchar = document.querySelector("#graficaid");
    const graficaUnidadesVenta = document.querySelector(
        "#graficaUnidadesVenta"
    );

    const ventasHoyValorTotal = document.querySelector("#ventasHoyValorTotal");
    /**
     * Datos del podio
     */
    const first_saller = document.querySelector("#first_saller");
    const first_seller_value = document.querySelector("#first_seller_value");
    const second_saller = document.querySelector("#second_saller");
    const second_seller_value = document.querySelector("#second_seller_value");
    const three_saller = document.querySelector("#three_saller");
    const three_seller_value = document.querySelector("#three_seller_value");

    const loaderJson = document.querySelector("#loaderJson");
    const second_podium = document.querySelector("#second_podium");
    const three_podium = document.querySelector("#three_podium");

    const podium = document.querySelector("#podium");

    const options = {
        style: "currency",
        currency: "COP",
    };

    loaderJson.setAttribute("style", "display:none;");

    async function getVentasMes() {
        const url = `/api/ventasDia`;

        try {
            const request = await fetch(url);
            const result = await request.json();
            constructTableResult(result);
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
         * Orden de los datos de mayor a menor
         */

        const ordenado = Object.entries(resumenVentasVendedor)
            .sort((a, b) => b[1].KCNT_REVENUE - a[1].KCNT_REVENUE)
            .reduce((acc, [key, value]) => {
                acc[key] = value;
                return acc;
            }, {});

        /**
         * Condicion si el objeto esta vacio
         */

        if (Object.keys(ordenado).length !== 0) {
            loaderJson.setAttribute("style", "display: none;");
            podium.setAttribute("style", "display: block;");

            /**
             * Construccion del podio con respecto al tamaño del objeto
             */

            switch (Object.keys(ordenado).length) {
                case 1:
                    first_saller.textContent = Object.keys(ordenado)[0];
                    first_seller_value.textContent = Number(
                        Object.values(ordenado)[0].KCNT_REVENUE
                    ).toLocaleString("es-CO", options);

                    second_podium.setAttribute("style", "display: none");
                    three_podium.setAttribute("style", "display: none");

                    break;

                case 2:
                    first_saller.textContent = Object.keys(ordenado)[0];
                    first_seller_value.textContent = Number(
                        Object.values(ordenado)[0].KCNT_REVENUE
                    ).toLocaleString("es-CO", options);

                    second_saller.textContent = Object.keys(ordenado)[1];
                    second_seller_value.textContent = Number(
                        Object.values(ordenado)[1].KCNT_REVENUE
                    ).toLocaleString("es-CO", options);
                    three_podium.setAttribute("style", "display: none");

                    break;

                default:
                    first_saller.textContent = Object.keys(ordenado)[0];
                    first_seller_value.textContent = Number(
                        Object.values(ordenado)[0].KCNT_REVENUE
                    ).toLocaleString("es-CO", options);

                    second_saller.textContent = Object.keys(ordenado)[1];
                    second_seller_value.textContent = Number(
                        Object.values(ordenado)[1].KCNT_REVENUE
                    ).toLocaleString("es-CO", options);

                    three_saller.textContent = Object.keys(ordenado)[2];
                    three_seller_value.textContent = Number(
                        Object.values(ordenado)[2].KCNT_REVENUE
                    ).toLocaleString("es-CO", options);
                    break;
            }
        } else {
            podium.setAttribute("style", "display: none;");
            loaderJson.setAttribute("style", "display: block;");
        }

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
        ventasHoyValorTotal.textContent = formateado;

        /**
         * Objeto formateado desde la cuarta posicion
         */

        const objetoDesdeLaCuartaPosicion = Object.entries(ordenado).slice(3);
        const objetoRecortadoFormateado = Object.fromEntries(
            objetoDesdeLaCuartaPosicion
        );

        if (Object.keys(objetoRecortadoFormateado).length !== 0) {
            /**
             * Mostrar la grafica
             */

            graficaDiaria(objetoRecortadoFormateado);
        }

        /**
         * Obteber la sumatoria de las unidades de venta
         */

        const resumenUnidadesDeVenta = datas.reduce((acc, curr) => {
            const unidadVenta = curr.TIP_SALES_UNIT;

            if (acc[unidadVenta]) {
                acc[unidadVenta].KCNT_REVENUE += parseFloat(curr.KCNT_REVENUE);
            } else {
                acc[unidadVenta] = {
                    KCNT_REVENUE: parseFloat(curr.KCNT_REVENUE),
                };
            }

            return acc;
        }, {});

        /**
         * Ordenar los datos de mayor a menor de las unidades de Venta
         */

        const unidadesOrdenadas = Object.entries(resumenUnidadesDeVenta)
            .sort((a, b) => b[1].KCNT_REVENUE - a[1].KCNT_REVENUE)
            .reduce((acc, [key, value]) => {
                acc[key] = value;
                return acc;
            }, {});

        if (Object.keys(unidadesOrdenadas).length !== 0) {
            /**
             * Construccion de grafica para las unidades de venta
             */

            graficarUnidadesDeVenta(unidadesOrdenadas);

            console.log(unidadesOrdenadas);
        } else {
            console.log("No se han registrado ventas en el dia");
        }
    }

    getVentasMes();

    /**
     *
     * @param {resumenVentasVendedor} : Datos resumidos y concatenados de las diferentes ventas diaras
     */

    function graficaDiaria(ordenado) {
        let delayed;

        const data = ordenado;
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
        };

        new Chart(idchar, {
            type: "bar",
            data: valores,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
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
            },
        });

        /**
         * Retrazo para borrar la grafica
         */

        setTimeout(() => {
            destroyGrafica(idchar);
        }, 293000);
    }

    function graficarUnidadesDeVenta(unidadesOrdenadas) {
        let delayed;

        const data = unidadesOrdenadas;
        const labels = Object.keys(data);
        const values = Object.values(data).map((item) => item.KCNT_REVENUE);

        const valores = {
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

        new Chart(graficaUnidadesVenta, {
            type: "pie",
            data: valores,
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 25,
                            }
                        }
                    },
                },
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
            },
        });

        /**
         * Retrazo para borrar la grafica
         */

        setTimeout(() => {
            destroyGrafica(graficaUnidadesVenta);
        }, 293000);
    }

    setInterval(getVentasMes, 300000);

    function destroyGrafica(grafica) {
        const chart = Chart.getChart(grafica);
        chart.destroy();
    }
});
