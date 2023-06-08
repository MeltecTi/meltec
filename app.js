const axios = require("axios");
const e = require("express");
require("dotenv").config();

const app = e();
const credentials = {
    username: process.env.SAP_USERNAME,
    password: process.env.SAP_PASSWORD,
};

const sapUrl = process.env.SAP_URL;

/**
 * Obtener las ventas en general
 */

let kpiValue = "";
function getDataSap() {
    const options = {
        method: "GET",
        url: `${sapUrl}sap/byd/odata/analytics/kpi/Kpi.svc/Kpi('Z1B2BB527DDCF9E26004D8265')/Value`,
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
        url: `${sapUrl}sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=99999&$filter=CDOC_INV_DATE eq datetime'${formattedDateNow}'&$format=json`,
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
    function obtenerDiaAnterior() {
        const hoy = new Date();
        const diaSemana = hoy.getDay();

        if (diaSemana === 1) {
            hoy.setDate(hoy.getDate() - 3);
        } else if (diaSemana === 0) {
            hoy.setDate(hoy.getDate() - 2);
        } else {
            hoy.setDate(hoy.getDate() - 1);
        }

        return hoy;
    }

    let datenow = obtenerDiaAnterior();
    datenow.setHours(0, 0, 0, 0);
    let formmatedDateNow = datenow.toISOString().slice(0, 19);

    const options = {
        method: "GET",
        url: `${sapUrl}sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=99999&$filter=CDOC_INV_DATE eq datetime'${formmatedDateNow}'&$format=json`,
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
        url: `${sapUrl}sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,CIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=9999&$format=json&$filter=CDOC_INV_DATE ge datetime'${formattedStartOfWeek}' and CDOC_INV_DATE le datetime'${formattedToday}'`,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            VentaSemana = response.data.d;
        })
        .catch((error) => {
            console.error(error);
        });
}

ventasSemanales();
setInterval(ventasSemanales, 5000);

/**
 * Ventas Semana anterior a la semana pasada
 */
let ventasSemanaAnteriorAnteriorValue = "";
function ventasSemanaAnteriorAnterior() {
    // Funcion para obtener la semana anterior a la semana pasada
    function SemanaAnterior() {
        const hoy = new Date();
        const dateSemanaPasada = new Date(
            hoy.getTime() - 7 * 24 * 60 * 60 * 1000
        );
        const semanaPasada = new Date(
            dateSemanaPasada.getTime() - 7 * 24 * 60 * 60 * 1000
        );
        return semanaPasada;
    }

    // Ultimo dia de la semana anterior a la semana pasada
    function lastDay() {
        const hoy = new Date();
        const dateSemanaPasada = new Date(
            hoy.getTime() - 7 * 24 * 60 * 60 * 1000
        );
        const semanaPasada = new Date(
            dateSemanaPasada.getTime() - 7 * 24 * 60 * 60 * 1000
        );

        semanaPasada.setDate(semanaPasada.getDate() + 4);

        return semanaPasada;
    }

    const firstDay = SemanaAnterior();
    const last = lastDay();

    firstDay.setHours(0, 0, 0, 0);
    last.setHours(0, 0, 0, 0);

    const dates = {
        first: firstDay.toISOString().slice(0, 19),
        lasted: last.toISOString().slice(0, 19),
    };

    const options = {
        method: "GET",
        url: `${sapUrl}sap/byd/odata/ana_businessanalytics_analytics.svc/RPCRMCIVIB_Q0001QueryResults?$select=TIPR_PROD_UUID,TDOC_YEAR_MONTH,TIP_SALES_UNIT,CDOC_UUID,CDOC_INV_DATE,TDPY_BILLFR_UUID,TIP_SAL_EMP,CIP_SAL_EMP,TIPR_REFO_CATCP,CIP_SALES_UNIT,KCNT_REVENUE,KCINV_QTY&$top=9999&$format=json&$filter=CDOC_INV_DATE ge datetime'${dates.first}' and CDOC_INV_DATE le datetime'${dates.lasted}'`,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            ventasSemanaAnteriorAnteriorValue = response.data.d;
        })
        .catch((error) => {
            console.error(error);
        });
}

ventasSemanaAnteriorAnterior();
setInterval(ventasSemanaAnteriorAnterior, 5000);

let employesSAP = {};
const getEmployesSAPBYD = () => {
    const options = {
        method: "GET",
        url: `${sapUrl}/sap/byd/odata/cust/v1/base_empleados/EmployeeCollection`,
        auth: credentials,
    };

    axios(options)
        .then((response) => {
            const data = response.data;

            if (response.status === 200) {
                const employees = data.d.results;

                employesSAP = response.data.d;

                const promises = employees.map((employee) => {
                    const uuid = employee.ObjectID;

                    const subCollections = [
                        "EmployeeEmployeePrivateAddressInformation",
                    ];

                    const subPromises = subCollections.map((subCollection) => {
                        const subUrl = `${sapUrl}/sap/byd/odata/cust/v1/base_empleados/EmployeeCollection('${uuid}')/${subCollection}`;

                        const optionsSubUrl = {
                            method: "GET",
                            url: subUrl,
                            auth: credentials,
                        };

                        return axios(optionsSubUrl)
                            .then((subResponse) => {
                                const subData = subResponse.data;

                                if (subResponse.status === 200) {
                                    employee[subCollection] =
                                        subData.d.results[0];
                                } else {
                                    employee[subCollection] = `Error al obtener los datps`;
                                }
                            })
                            .catch((error) => {
                                console.log(
                                    "Error al obtener los datos: ",
                                    error
                                );
                            });
                    });

                    return Promise.all(subPromises);
                });

                Promise.all(promises)
                    .then(() => {
                        console.log(employesSAP);
                    })
                    .catch((error) => {
                        console.log(
                            "Error al obtener los datos de la subcoleccion: ",
                            error
                        );
                    });
            } else {
                console.log(
                    "Error al obtener los datos de la coleccion principal"
                );
            }
        })
        .catch((error) => {
            console.error(
                "Error al obtener los datos de la coleccion principal: ",
                error
            );
        });
};
getEmployesSAPBYD();

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

app.get("/ventasSemanales", (req, res) => {
    res.send(JSON.stringify(VentaSemana.results));
});

app.get("/ventasSemanaAnteriorAnterior", (req, res) => {
    res.send(JSON.stringify(ventasSemanaAnteriorAnteriorValue.results));
});

app.get("/listofemplyes", (req, res) => {
    res.send(JSON.stringify(employesSAP.results));
});

// app.get("/employ", (req, res) => {
//     let EmployeeEmployeePrivateAddressInformation = {};
//     const filter = req.query["$filter"];

//     const uuid = filter.split("'")[1];

//     const options = {
//         method: "GET",
//         url: `${sapUrl}/sap/byd/odata/cust/v1/base_empleados/EmployeeCollection('${uuid}')/EmployeeEmployeePrivateAddressInformation`,
//         auth: credentials,
//     };

//     axios(options)
//         .then((result) => {
//             EmployeeEmployeePrivateAddressInformation = result.data.d;
//             res.send(JSON.stringify(EmployeeEmployeePrivateAddressInformation.results));
//         })
//         .catch((error) => {
//             console.log(error);
//             res.status(500).send('Error en la solicitud');
//         });

// });

const port = process.env.PORT || 3000;
app.listen(port, () => {
    console.log(`Server running in port ${port}`);
});
