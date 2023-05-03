const axios = require("axios");
const e = require("express");
require("dotenv").config();

const app = e();
const credentials = {
    username: process.env.SAP_USERNAME,
    password: process.env.SAP_PASSWORD,
};

/**
 * Obtener las ventas en general
 */

let kpiValue = "";
function getDataSap() {
    const options = {
        method: "GET",
        url: process.env.URL_SAPKPI,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            kpiValue = response.data.d;
        })
        .catch((error) => {
            console.error(error);
        });
}

getDataSap();
setInterval(getDataSap, 5000);

/**
 * Obtener ventas del dia
 */

let ventasMes = "";
function getVentasDia() {
    let datenow = new Date();
    datenow.setHours(0, 0, 0, 0);
    let formattedDateNow = datenow.toISOString().slice(0, 19);

    const options = {
        method: "GET",
        url: `https://my345513.sapbydesign.com/sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=99999&$filter=CDOC_INV_DATE eq datetime'${formattedDateNow}'&$format=json`,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            ventasMes = response.data.d;
        })
        .catch((error) => {
            console.error(error);
        });
}
getVentasDia();
setInterval(getVentasDia, 5000);

/**
 * Ventas al dia anterior
 */

let ventasDiaAnteriorvalue = "";
function ventasDiaAnterior() {
    let datenow = new Date();
    datenow.setDate(datenow.getDate() - 1);
    datenow.setHours(0, 0, 0, 0);
    let formmatedDateNow = datenow.toISOString().slice(0, 19);

    const options = {
        method: "GET",
        url: `https://my345513.sapbydesign.com/sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=99999&$filter=CDOC_INV_DATE eq datetime'${formmatedDateNow}'&$format=json`,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            ventasDiaAnteriorvalue = response.data.d;
        })
        .catch((error) => {
            console.error(error);
        });
}
ventasDiaAnterior();
setInterval(ventasDiaAnterior, 5000);

/**
 * Ventas de la Semana
 */

let VentaSemana = "";
function ventasSemanales() {
    /**
     * Obtener los datos de la semana actual
     * Creamos un objeto de fecha
     */
    const date = new Date();

    // Obtenemos el día actual de la semana (0 es Domingo, 1 es Lunes, etc.)
    const today = date.getDay();

    // Obtenemos la fecha de inicio de la semana restando los días transcurridos desde el Lunes
    const startOfWeek = new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate() - (today - 1)
    );

    // Formateamos las fechas a un string
    const formattedToday = date.toISOString().slice(0, 19);
    const formattedStartOfWeek = startOfWeek.toISOString().slice(0, 19);

    /**
     * Opciones de la solicitud axios
     */

    const options = {
        method: "GET",
        url: `https://my345513.sapbydesign.com/sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,CIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=9999&$format=json&$filter=CDOC_INV_DATE ge datetime'${formattedStartOfWeek}' and CDOC_INV_DATE le datetime'${formattedToday}'`,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            VentaSemana = response.data.d;
        })
        .catch((error) => {
            console.error(error);
        })
}

ventasSemanales();
setInterval(ventasSemanales, 5000);

/**
 * Url para la Api y conectar con LARAVEL
 */

app.get("/", (req, res) => {
    res.send(JSON.stringify(kpiValue));
});

app.get("/ventasDia", (req, res) => {
    res.send(JSON.stringify(ventasMes.results));
});

app.get("/ventasDiaAnterior", (req, res) => {
    res.send(JSON.stringify(ventasDiaAnteriorvalue.results));
});

app.get('/ventasSemanales', (req, res) => {
    res.send(JSON.stringify(VentaSemana.results));
})

const port = process.env.PORT || 3000;
app.listen(port, () => {
    console.log(`Server running in port ${port}`);
});
