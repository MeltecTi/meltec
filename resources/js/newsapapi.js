"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const sapdata = document.querySelector("#sapdata");
    const $grafica = document.querySelector("#grafica");

    async function getData() {
        const url = `/api/sapData`;
        try {
            const request = await fetch(url);

            const res = await request.json();
            let result = res.results;
            constructorOdataSap(result);
        } catch (error) {
            console.error(error);
        }
    }

    function constructorOdataSap(result) {
        limpiardiv();

        const options = {
            style: "currency",
            currency: "COP",
        };

        const {
            CurrentValueText,
            TargetValue,
            CurrentValue,
            TargetDeltaPct,
        } = result;

        // Titulo de la oData
        const h2Tile = document.createElement("H4");
        h2Tile.textContent = CurrentValueText;

        // Meta principal del mes
        const metaMes = TargetValue;
        const metaMesFormatted = Number(metaMes).toLocaleString(
            "es-CO",
            options
        );

        const metaMesDisplay = document.createElement("P");
        metaMesDisplay.textContent = metaMesFormatted;

        /**
         * Valores de venta actuales
         */

        const h3VentasAct = document.createElement("H4");
        h3VentasAct.textContent = `Ventas al dia ${new Date().toLocaleString()}`;
        const ventasActualValue = Number(CurrentValue).toLocaleString(
            "es-co",
            options
        );
        const ventasActualValueDisplay = document.createElement("P");
        ventasActualValueDisplay.textContent = `${ventasActualValue} - ${
            (100 - Math.abs(TargetDeltaPct)).toFixed(2)
        } %`;

        /**
         * Porcentaje de venta con respecto al faltante en año actual
         */

        const h3Porcentaje = document.createElement("H4");
        h3Porcentaje.textContent = `Porcentaje Faltante`;

        const porcentajeVentaRestante = document.createElement("P");
        porcentajeVentaRestante.textContent = `${Math.abs(TargetDeltaPct)}%`;

        /**
         * Mostrar en pantalla los valores
         */

        sapdata.appendChild(h2Tile);
        sapdata.appendChild(metaMesDisplay);
        sapdata.appendChild(h3VentasAct);
        sapdata.appendChild(ventasActualValueDisplay);
        sapdata.appendChild(h3Porcentaje);
        sapdata.appendChild(porcentajeVentaRestante);

        graficarData(result);
    }

    getData();

    function graficarData(dataApi) {
        /**
         * Datos Iniciales
         * @param dataApi = object
         */

        let delayed;
        const {
            CurrentValue,
            TargetValue,
            ThresholdAlertLow,
            ThresholdWarningLow,
        } = dataApi;

        function colorize(opaque) {
            return (ctx) => {
                const v = ctx.parsed.y;
                const c =
                    v < Math.floor(ThresholdAlertLow)
                        ? "#D60000"
                        : v < Math.floor(ThresholdWarningLow)
                        ? "#F46300"
                        : v < Math.floor(TargetValue)
                        ? "#0358B6"
                        : "#456596";

                return opaque ? c : "#456596";
            };
        }

        new Chart($grafica, {
            type: "bar",
            data: {
                labels: ["Meltec 2023"],
                datasets: [
                    {
                        label: ["Meta Meltec 2023"],
                        backgroundColor: "rgba(23,62,124,0.5)",
                        borderColor: "rgba(23,62,124,0.8)",
                        hoverBackgroundColor: "rgba(23,62,124,0.75)",
                        hoverBorderColor: "rgba(23,62,124,1)",
                        data: [TargetValue],
                    },
                    {
                        label: ["Venta Actual"],
                        backgroundColor: colorize(true),
                        borderColor: colorize(true),
                        hoverBackgroundColor: "rgba(179,178,178,0.75)",
                        hoverBorderColor: "rgba(179,178,178,1)",
                        data: [CurrentValue],
                    },
                ],
            },
            options: {
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
                plugins: {
                    legend: {
                        position: "top",
                    },
                    title: {
                        display: true,
                        text: "Ventas Meltec 2023",
                    },
                    subtitle: {
                        display: true,
                        text: `Ultima Actualizacion: ${new Date().toLocaleString(
                            "es-CO",
                            {
                                weekday: "long",
                                year: "numeric",
                                month: "long",
                                day: "numeric",
                                hour: "numeric",
                                minute: "numeric",
                                second: "numeric",
                            }
                        )}`,
                        color: "blue",
                        font: {
                            size: 12,
                            weight: "normal",
                            style: "italic",
                        },
                        padding: {
                            bottom: 10,
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
        }, 295000);
    }

    setInterval(getData, 300000);

    function destroyGrafica() {
        const chart = Chart.getChart($grafica);
        chart.destroy();
    }
    function limpiardiv() {
        while (sapdata.firstChild) {
            sapdata.removeChild(sapdata.firstChild);
        }
    }
});
