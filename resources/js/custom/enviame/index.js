"use strict";
import axios from "axios";

document.addEventListener("DOMContentLoaded", () => {
    getBussinesEnviame();
});
const apiToken = document
    .querySelector('meta[name="api-token"]')
    .getAttribute("content");

let bussiness = [];

const getBussinesEnviame = async () => {
    const url = `/api/getseelers`;
    try {
        const response = await axios.get(url, {
            headers:{
                Authorization: `Bearer: ${apiToken}`,
            }
        });

        console.log(response);
    } catch (error) {
        console.error(error);
    }
};
