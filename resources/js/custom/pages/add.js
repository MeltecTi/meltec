"use strict";

document.addEventListener("DOMContentLoaded", () => {
    /**
     * Inicializacion del Script
     */

    selectTemplate();
});

/**
 * Variables Generales
 */
const apiToken = document
    .querySelector('meta[name="api-token"]')
    .getAttribute("content");

const _token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

const dataTemplates = document.querySelector("#dataTemplates");

let dataFormSendPost = {};

/**
 * Funciones autollamadas en el Load
 */

const selectTemplate = () => {
    const templates = document.querySelector("#templates");
    templates.addEventListener("change", (e) => {
        const templateIdSelected = e.target.value;

        dataFormSendPost.template_id = templateIdSelected;

        switch (templateIdSelected) {
            case "1":
                formMarcas();
                break;

            default:
                pageDefault();
                break;
        }
    });
};

// Formularios dinamicos

/**
 * Formulario de Marcas
 */
const formMarcas = () => {
    clearDiv();

    const generalDiv = document.createElement("DIV");
    generalDiv.classList.add("g-2", "mb-3");

    /**
     * Formulario
     */
    const form = document.createElement("FORM");
    form.setAttribute("enctype", "multipart/formdata");
    form.classList.add("row");

    const columnForm = document.createElement("DIV");
    columnForm.classList.add("col-9");

    const markInputDiv = document.createElement("DIV");
    markInputDiv.classList.add("form-floating", "mb-3");

    const markInput = document.createElement("INPUT");
    markInput.setAttribute("type", "text");
    markInput.setAttribute("id", "name");
    markInput.setAttribute("name", "name");
    markInput.classList.add("form-control");

    // Evento Blur
    markInput.addEventListener("blur", (e) => {
        let value = e.target.value.trim();
        searchMark(value);
    });

    const markLabel = document.createElement("LABEL");
    markLabel.setAttribute("for", "name");
    markLabel.textContent = "Marca Aliada";

    markInputDiv.appendChild(markInput);
    markInputDiv.appendChild(markLabel);

    const urlMarkInputDiv = document.createElement("DIV");
    urlMarkInputDiv.classList.add("form-floating", "mb-3");

    const urlMarkInput = document.createElement("INPUT");
    urlMarkInput.setAttribute("type", "text");
    urlMarkInput.setAttribute("id", "videourl");
    urlMarkInput.setAttribute("name", "videourl");
    urlMarkInput.classList.add("form-control");

    const urlMarkLabel = document.createElement("LABEL");
    urlMarkLabel.setAttribute("for", "markName");
    urlMarkLabel.textContent = "Url del video";

    urlMarkInputDiv.appendChild(urlMarkInput);
    urlMarkInputDiv.appendChild(urlMarkLabel);

    const descriptionMarkInputDiv = document.createElement("DIV");
    descriptionMarkInputDiv.classList.add("form-floating", "mb-3");

    const descriptionMarkInput = document.createElement("TEXTAREA");
    descriptionMarkInput.classList.add("form-control");
    descriptionMarkInput.setAttribute("id", "content");
    descriptionMarkInput.setAttribute("name", "content");
    descriptionMarkInput.setAttribute(
        "style",
        "height: 250px; line-height: normal;"
    );

    /**
     * CKEDITOR
     */

    ClassicEditor.create(descriptionMarkInput)
        .then((editor) => {
            editor.model.document.on("change:data", () => {
                const contenidos = descriptionMarkInput;
                contenidos.value = editor.getData();
            });
        })
        .catch((error) => {
            console.log(error);
        });

    const descriptionMarkLabel = document.createElement("LABEL");
    descriptionMarkLabel.setAttribute("for", "content");
    descriptionMarkLabel.textContent = "Descripcion de la marca";

    descriptionMarkInputDiv.appendChild(descriptionMarkInput);
    // descriptionMarkInputDiv.appendChild(descriptionMarkLabel);

    const optionsDiv = document.createElement("DIV");
    optionsDiv.classList.add("d-flex", "justify-content-end");

    const sliderOption = document.createElement("DIV");
    sliderOption.classList.add("form-check", "form-switch");

    const sliderOptionInput = document.createElement("INPUT");
    sliderOptionInput.classList.add("form-check-input");
    sliderOptionInput.setAttribute("type", "checkbox");
    sliderOptionInput.setAttribute("role", "switch");
    sliderOptionInput.setAttribute("id", "enabled");
    sliderOptionInput.setAttribute("name", "enabled");
    sliderOptionInput.setAttribute("checked", true);

    const sliderOptionLabel = document.createElement("LABEL");
    sliderOptionLabel.classList.add("form-check-label");
    sliderOptionLabel.setAttribute("for", "enabled");
    sliderOptionLabel.textContent = "Habilitar Pagina";

    sliderOption.appendChild(sliderOptionInput);
    sliderOption.appendChild(sliderOptionLabel);

    const buttonSend = document.createElement("BUTTON");
    buttonSend.classList.add("btn", "btn-primary");
    buttonSend.setAttribute("type", "submit");
    buttonSend.setAttribute("style", "margin-left: 1rem;");
    buttonSend.textContent = "Publicar Marca";

    optionsDiv.appendChild(sliderOption);
    optionsDiv.appendChild(buttonSend);

    /**
     * Foto del Formulario
     */

    const columnFormImage = document.createElement("DIV");
    columnFormImage.classList.add("col-3");

    const inputFormImage = document.createElement("INPUT");
    inputFormImage.setAttribute("type", "file");
    inputFormImage.setAttribute("name", "markLogo");
    inputFormImage.setAttribute("id", "markLogo");
    inputFormImage.setAttribute("accept", "image/png, image/jpeg, image/webp");
    inputFormImage.classList.add("form-control");

    columnFormImage.appendChild(inputFormImage);

    /**
     * Agregar los campos al Formulario
     */
    columnForm.appendChild(markInputDiv);
    columnForm.appendChild(urlMarkInputDiv);
    columnForm.appendChild(descriptionMarkInputDiv);
    columnForm.appendChild(optionsDiv);

    form.appendChild(columnForm);
    form.appendChild(columnFormImage);

    // Evento para enviar los datos
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        let dataForm = new FormData(form);

        for (let [key, value] of dataForm.entries()) {
            dataFormSendPost[key] = value;
        }

        createPage(dataFormSendPost);
    });

    /**
     * Agregar el Formulario al Div general
     */
    generalDiv.appendChild(form);

    //Integracion de todo
    dataTemplates.appendChild(generalDiv);
};


/**
 * Formulario de template por defecto
 */

const pageDefault = () => {
    clearDiv();
}

/**
 * Funcion para limpiar los datos
 */

const clearDiv = () => {
    while (dataTemplates.firstChild) {
        dataTemplates.removeChild(dataTemplates.firstChild);
    }
};

/**
 * Funciones Async
 */

const createPage = async (data) => {
    try {
        const url = `/api/menus`;
        Swal.fire({
            title: "Publicando Pagina!",
            html: "Por favor espere!!",
            timerProgressBar: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        axios
            .post(url, data, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Authorization: `Bearer ${apiToken}`,
                    "X-CSRF-TOKEN": _token,
                },
            })
            .then((response) => {
                Swal.fire({
                    icon: "success",
                    title: "Exito!!",
                    text: response.message,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.assign("/home/menus");
                    }
                });
                return;
            })
            .catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: error.message,
                });
            });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error.message,
        });
    }
};

const searchMark = async (mark) => {
    try {
        if (mark.trim().length !== 0) {
            const url = `/api/marks/${mark}`;
            axios
                .get(url, {
                    headers: {
                        Authorization: `Bearer ${apiToken}`,
                    },
                })
                .then((response) => {
                    const id = response.data.data.id;
                    dataFormSendPost.mark_id = id;
                    return;
                })
                .catch((error) => {
                    return;
                });
        }
    } catch (error) {
        return;
    }
};
