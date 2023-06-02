"use strict";

import axios from "axios";

const apiToken = document
    .querySelector('meta[name="api-token"]')
    .getAttribute("content");

const _token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

document.addEventListener("DOMContentLoaded", () => {
    ClassicEditor.create(document.querySelector("#contentBlog"))
        .then((editor) => {
            editor.model.document.on("change:data", () => {
                const contenidos = document.querySelector(
                    "textarea#contentBlog"
                );
                contenidos.value = editor.getData();
            });
        })
        .catch((error) => {
            console.log(error);
        });
});

const prueba = document.querySelector("#prueba");

prueba.addEventListener("click", (e) => {
    e.preventDefault();
    crearCalendario();
});

async function crearCalendario() {
    try {
        const url = "/api/calendar/create";

        let data = new FormData();

        data.append("email", "jcuadros@meltec.com.co");
        data.append("email123", "jcuadadadros@meltec.com.co");

        axios
            .post(url, data, {
                headers: {
                    "X-CSRF-TOKEN": _token,
                    Authorization: `Bearer ${apiToken}`,
                },
            })
            .then((result) => {
                console.log(result);
            })
            .catch((error) => {
                console.log(error);
            });
    } catch (error) {
        console.error(error);
    }
}
