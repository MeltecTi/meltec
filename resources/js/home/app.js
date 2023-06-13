"use strict";
import axios from "axios";
import { Chart } from "chart.js";


document.addEventListener("DOMContentLoaded", () => {
    getTodaySales();
    getYearSales();
});

let totalDiario = 0;
let yearGoal = 0;
let yearTotal = 0;

const options = {
    style: "currency",
    currency: "COP",
};

const getTodaySales = async () => {
    try {
        const url = `/api/ventasDia`;

        axios
            .get(url)
            .then((result) => {
                const datas = result.data;

                // Agrupar las ventas de cada vendedor

                const resumeVentas = datas.reduce((acc, curr) => {
                    const vendedor = curr.TIP_SAL_EMP;

                    if (acc[vendedor]) {
                        acc[vendedor].totalVentas += parseFloat(
                            curr.KCNT_REVENUE
                        );
                    } else {
                        acc[vendedor] = {
                            totalVentas: parseFloat(curr.KCNT_REVENUE),
                        };
                    }

                    return acc;
                }, {});

                // Ordenar las ventas
                const sortedResumenVentas = Object.entries(resumeVentas)
                    .sort((a, b) => b[1].totalVentas - a[1].totalVentas)
                    .reduce((acc, [key, value]) => {
                        acc[key] = value;
                        return acc;
                    }, {});

                bestBuller(sortedResumenVentas);

                // Funcion para obtener la sumatoria de todos las ventas
                sumTotalDiario(datas);
            })
            .catch((error) => {
                console.error(error);
            });
    } catch (error) {
        console.error(error);
    }
};

const getYearSales = async () => {
    // Obtener los datos anuales de ventas en SAP
    try {
        const url = `/api/sapData`;

        axios
            .get(url)
            .then((result) => {
                const totalPercent = document.querySelector('#totalPercent');
                const totalYearValue = document.querySelector('#totalYearValue');

                yearGoal = parseFloat(result.data.results.TargetValue);
                yearTotal = parseFloat(result.data.results.CurrentValue);

                totalPercent.textContent = actuallityPercent();
                totalYearValue.textContent = formatPrice(yearTotal);
            })
            .catch((error) => {
                console.error(error);
            });
    } catch (error) {
        console.error(error);
    }
};

const sumTotalDiario = (datas) => {
    const rateTodaySales = document.querySelector("#rateTodaySales");
    // Obtener el total diario
    datas.forEach((venta) => {
        const { KCNT_REVENUE } = venta;

        totalDiario += parseFloat(KCNT_REVENUE);
    });

    // Formatear el dato a peso colombiano
    const formatedTotal = formatPrice(totalDiario);
    rateTodaySales.textContent = formatedTotal;
};

const bestBuller = (buller) => {
    const bestBuller = document.querySelector('#bestBuller');
    const sell = Object.values(buller)[0].totalVentas;
    const sellFormatted = formatPrice(sell);
    bestBuller.textContent = sellFormatted;
}
// Funciones de auxilio y ayuda
const actuallityPercent = () => {
    const numerator =  100 * yearTotal;
    const percent = (numerator / yearGoal).toFixed(2);

    return `${percent}%`;
}

const formatPrice = (numberParsed) => {
    const formatted = Number(numberParsed).toLocaleString('es-CO', options);
    return formatted
}