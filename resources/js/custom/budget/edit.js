"use strict";

import axios from "axios";

document.addEventListener("DOMContentLoaded", () => {
    const apiToken = document
        .querySelector('meta[name="api-token"]')
        .getAttribute("content");

    const _token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const formData = document.querySelector("#formData");
    const id = document.querySelector("#id").value;
    formData.addEventListener("submit", (e) => {
        e.preventDefault();
        let form = new FormData(formData);
        updateData(id, form);
    });

    async function updateData(id, data) {
        const url = `/api/budgets/edit/${id}`;
        try {
            const response = await axios.put(url, data, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": _token,
                    Authorization: `Bearer ${apiToken}`,
                },
            });

            if (response.status === 200) {
                Swal.fire({
                    title: "Exito",
                    text: response.data.message,
                    icon: "success",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('/home/budgets/')
                    }
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: error.message,
            });
        }
    }
});
