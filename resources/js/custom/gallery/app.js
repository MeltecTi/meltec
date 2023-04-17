"use strict";
document.addEventListener("DOMContentLoaded", () => {
    obtenerImagenes();

    let imagenes = [];
    const sectionImages = document.querySelector("#sectionImages");
    const _token = document.querySelector('meta[name="csrf-token"]');

    // Funcion Asincrona para obtener las imagenes
    async function obtenerImagenes() {
        const url = `/api/gallery`;

        try {
            const request = await fetch(url);

            if (!request.ok) {
                throw new Error("Hubo un error en obtener los datos");
            }

            const result = await request.json();
            imagenes = result.images;
            mostrarImagenes();
            return;
        } catch (error) {
            console.log(error);
            return;
        }
    }

    // Mostrar imagenes en pantalla
    function mostrarImagenes() {
        limpiarPantalla();

        if (imagenes.length === 0) {
            const imagesEmpty = document.createElement("P");
            imagesEmpty.classList.add("text-center", "lead");
            imagesEmpty.textContent = "No hay imagenes subidas";

            sectionImages.appendChild(imagesEmpty);
            return;
        }

        imagenes.forEach((imagen) => {
            const { id, file } = imagen;

            const divContainerImages = document.createElement("DIV");
            divContainerImages.classList.add("col", "mb-3");
            divContainerImages.onclick = function () {
                deleteImage(id);
            };

            const cardImage = document.createElement("DIV");
            cardImage.classList.add("cardImage");

            const cardContent = document.createElement("DIV");
            cardContent.classList.add("card2Image");

            const ImageContent = document.createElement("IMG");
            ImageContent.classList.add("w-100", "img-responsive");
            ImageContent.setAttribute("src", `/storage/gallery/${file}`);

            cardContent.appendChild(ImageContent);
            cardImage.appendChild(cardContent);

            divContainerImages.appendChild(cardImage);
            sectionImages.appendChild(divContainerImages);
        });
    }

    // Funcion para borrar la imagen
    async function deleteImage(id) {
        const data = new FormData();
        data.append("id", id);

        const url = `/home/gallery/${id}`;

        Swal.fire({
            title: "¿Estas seguro que deses borrar esta imagen?",
            icon: "warning",
            toast: true,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Borrar!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const request = await fetch(url, {
                        headers: {
                            "X-CSRF-TOKEN": _token.content,
                            "Content-Type": "multipart/form-data",
                        },
                        method: "DELETE",
                        body: data,
                        mode: "cors",
                    });

                    if (!request.ok) {
                        throw new Error("Hubo un error al borrar la Imagen");
                    }

                    const result = await request.json();

                    if (result.message === "ok") {
                        Toastify({
                            text: `Imagen Borrada correctamente`,
                            style: {
                                background: "#198754",
                            },
                            duration: 3000,
                        }).showToast();

                        obtenerImagenes();
                    }
                } catch (error) {
                    Toastify({
                        text: error,
                        style: {
                            background: "#dc3545",
                        },
                        duration: 3000,
                    }).showToast();
                    return;
                }
            }
        });
    }

    Dropzone.options.myGreatDropzone = {
        paramName: "file",
        maxFilesize: 12,
        acceptedFiles: ".jpeg, .jpg, .png, .webp",
        addRemoveLinks: true,
        timeout: 5000,
        success: function (file, response) {
            console.log(response);
            obtenerImagenes();
        },
        error: function (file, response) {
            return false;
        },
    };

    // Limpiar la pantalla de las imagenes
    function limpiarPantalla() {
        while (sectionImages.firstChild) {
            sectionImages.removeChild(sectionImages.firstChild);
        }
    }
});
