"use strict";
import axios from "axios";
import Swal from "sweetalert2";

const apiToken = document
    .querySelector('meta[name="api-token"]')
    .getAttribute("content");
const _token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
    
const formCreatedToken = document.querySelector("#formCreatedToken");
formCreatedToken.addEventListener("submit", (e) => {
    e.preventDefault();

    const application_name = document.querySelector("#application_name");

    if (
        !application_name.value.length == 0 ||
        !application_name.value.length == null
    ) {
        let data = new FormData();
        data.append("application_name", application_name.value);

        newApiToken(data);
    } else {
        Swal.fire("Ups!!", "El campo no puede estar vacio", "error");
    }
});

const newApiToken = async (data) => {
    try {
        const url = `/api/generateAppToken`;
        const headers = {
            Accept: "application/json",
            "X-CSRF-TOKEN": _token,
            Authorization: `Bearer ${apiToken}`,
            "Content-Type": "application/json",
        };

        const response = await axios.post(url, data, { headers });

        console.log(response);
    } catch (error) {
        console.error(error);
    }
};
