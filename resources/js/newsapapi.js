"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const $grafica = document.querySelector("#grafica");
    
    const progressBar = document.querySelector('#progressBar');

    const options = {
        style: "currency",
        currency: "COP",
    };

    async function getData() {
        const url = `/api/sapData`;
        try {
            const request = await fetch(url);

            const res = await request.json();
            let result = res.results;
            constructProgressbar(result);
        } catch (error) {
            console.error(error);
        }
    }


    function constructProgressbar(result) {
        limpiarProgressBar();

        const { CurrentValue, TargetDeltaPct } = result;

        const porcentajeAbsoluto = Math.abs(TargetDeltaPct);
        const porcentajeActual = 100 - porcentajeAbsoluto;

        const bar = document.createElement('DIV');
        bar.classList.add('progress-bar', 'progress-bar-striped', 'progress-bar-animated', 'fs-5');
        bar.setAttribute('style', `width: ${porcentajeActual.toFixed(2)}%`)
        bar.textContent = `${porcentajeActual.toFixed(2)}% - ${Number(CurrentValue).toLocaleString('es-CO', options)}`

        progressBar.setAttribute('aria-valuenow', porcentajeActual.toFixed(2) );
        progressBar.appendChild(bar);

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
    function limpiarProgressBar() {
        while (progressBar.firstChild) {
            progressBar.removeChild(progressBar.firstChild);
        }
    }
});
