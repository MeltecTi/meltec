const axios = require("axios");
const e = require("express");
const { createProxyMiddleware } = require("http-proxy-middleware");

getDataSap();

function getDataSap() {
  const app = e();

  app.use(
    "/sap",
    createProxyMiddleware({
      target: "https://my345513.sapbydesign.com",
      changeOrigin: true,
      auth: "CFRANCO:Sp@rt@n012569*-$",
    })
  );

  app.listen(4000);
  
  const options = {
    method: "get",
    url: "http://localhost:3000/sap/byd/odata/analytics/kpi/Kpi.svc/Kpi('Z1B2BB527DDCF9E26004D8265')/Value",
    auth: {
      username: "CFRANCO",
      password: "Sp@rt@n012569*-$",
    },
  };

  axios(options)
    .then((response) => {
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
}
