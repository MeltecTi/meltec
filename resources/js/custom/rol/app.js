"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const apiToken = document
        .querySelector('meta[name="api-token"]')
        .getAttribute("content");

    const _token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    obtenerUser();
    obtenerRoles();

    let roles = [];
    let admin;
    let permissions = [];
    const resulFetch = document.querySelector("#resulFetch");
    const createNewRol = document.querySelector("#createNewRol");
    const createNewPermission = document.querySelector("#createNewPermission");
    const permisosAgregados = document.querySelector("#permisosAgregados");
    const createPermissions = document.querySelector("#createPermissions");
    const loader = document.querySelector("#loader");

    createNewRol.addEventListener("submit", sendData);
    createNewPermission.addEventListener("submit", newPermission);
    createPermissions.addEventListener("click", postpermisos);

    loader.setAttribute("style", "display: none;");

    async function obtenerUser() {
        const url = `/api/user`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: "Bearer " + apiToken,
                },
            });

            if (!request.ok) {
                throw new Error("Error al obtener el usuario");
            }

            const result = await request.json();
            admin = result.admin;
        } catch (error) {
            console.log(error);
        }
    }

    async function obtenerRoles() {
        const url = `/api/roles`;

        try {
            const request = await fetch(url, {
                headers: {
                    Authorization: "Bearer " + apiToken,
                },
            });

            const result = await request.json();

            if (!request.ok) {
                throw new Error(result.message);
            }

            if (result.success) {
                roles = result.roles;
                mostrarRoles();
            }
        } catch (error) {
            Swal.fire("Ups!!", error.message, "error");
        }
    }

    async function sendData(e) {
        e.preventDefault();
        const url = `/api/roles`;
        let data = new FormData(this);
        try {
            const request = await fetch(url, {
                headers: {
                    "X-CSRF-TOKEN": _token,
                    Authorization: `Bearer ${apiToken}`,
                },
                method: "POST",
                body: data,
                mode: "cors",
            });
            const result = await request.json();

            if (!request.ok) {
                throw new Error(`${result.message} - Codigo ${result.code}`);
            }

            if (result.success) {
                Toastify({
                    text: result.message,
                    style: {
                        background: "#198754",
                    },
                    duration: 3000,
                }).showToast();

                obtenerRoles();
            }
        } catch (error) {
            Swal.fire("Ups!!", error.message, "error");
        }
    }

    // Agregar permisos Nuevos

    async function newPermission(e) {
        e.preventDefault();
        const requestData = new FormData(this);
        for (const permission of requestData) {
            const permissionObj = {
                name: permission[1],
                guard_name: "api",
            };
            permissions = [...permissions, permissionObj];
        }
        mostrarPermisos(permissions);
    }

    async function postpermisos() {
        const url = `/api/permissions`;
        loader.setAttribute("style", "display: flex; justify-content: center;");

        try {
            const request = await fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": _token,
                    Authorization: `Bearer ${apiToken}`,
                    Accept: "application/json",
                },
                method: "POST",
                body: JSON.stringify(permissions),
                mode: "cors",
            });
            const result = await request.json();

            if (!request.ok) {
                throw new Error(result.message);
            }

            if (result.success) {
                loader.setAttribute("style", "display: none;");

                Toastify({
                    text: result.message,
                    style: {
                        background: "#198754",
                    },
                    duration: 3000,
                }).showToast();

                permissions = [];
                mostrarPermisos(permissions);
            }
        } catch (error) {
            loader.setAttribute("style", "display: none;");
            Swal.fire("Ups!!", error.message, "error");
        }
    }

    // Mostrar los permisos a agregar
    function mostrarPermisos(permissions) {
        limpiarPermisosAgregardos();

        const table = document.createElement("TABLE");
        table.classList.add("table", "table-hover");

        const tbody = document.createElement("TBODY");
        permissions.forEach((per) => {
            const { name } = per;
            const tr = document.createElement("TR");
            const tdName = document.createElement("TD");
            tdName.textContent = name;

            tr.appendChild(tdName);
            tbody.appendChild(tr);
        });
        table.appendChild(tbody);
        permisosAgregados.appendChild(table);

        if (permissions.length !== 0) {
            createPermissions.disabled = false;
        }
    }

    function mostrarRoles() {
        limpiarRoles();

        const table = document.createElement("TABLE");
        table.classList.add("table", "table-hover");

        const thead = document.createElement("THEAD");
        const trhead = document.createElement("TR");
        trhead.innerHTML = `
            <th>Rol</th>
            <th>Opciones</th>
        `;
        thead.appendChild(trhead);

        const tbody = document.createElement("TBODY");
        roles.forEach((rol) => {
            const { id, name } = rol;

            const tr = document.createElement("TR");
            const nameRol = document.createElement("TD");
            nameRol.textContent = name;

            const tdListadoOpciones = document.createElement("TD");

            const buttonEditar = document.createElement("A");
            buttonEditar.setAttribute("href", `/home/roles/${id}/edit`);
            buttonEditar.classList.add("btn", "btn-info");
            buttonEditar.textContent = `Editar Rol`;

            tdListadoOpciones.appendChild(buttonEditar);

            const formBorrar = document.createElement("FORM");
            formBorrar.classList.add("deleteForm");
            formBorrar.setAttribute("data-value", id);
            formBorrar.setAttribute("style", "display: inline;");
            formBorrar.onsubmit = function (e) {
                e.preventDefault();
                deleteFunction(id);
            };

            const buttonBorrar = document.createElement("INPUT");
            buttonBorrar.setAttribute("type", "submit");
            buttonBorrar.classList.add("btn", "btn-danger");
            buttonBorrar.setAttribute("value", "Eliminar Rol");

            formBorrar.appendChild(buttonBorrar);
            tdListadoOpciones.appendChild(formBorrar);

            tr.appendChild(nameRol);

            if (admin) {
                tr.appendChild(tdListadoOpciones);
            }

            tbody.appendChild(tr);
        });
        table.appendChild(thead);
        table.appendChild(tbody);
        resulFetch.appendChild(table);
    }

    function deleteFunction(id) {
        const url = `/api/roles/${id}`;
        const data = new FormData();
        data.append("id", id);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: false,
        });

        swalWithBootstrapButtons
            .fire({
                title: "¿Estas seguro que deseas eliminar este Rol?",
                text: "Esta accion no se podra deshacer, Los usuarios afectados no podran iniciar Sesion!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true,
            })
            .then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const request = await fetch(url, {
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": _token,
                                Authorization: `Bearer ${apiToken}`,
                                Accept: "application/json",
                            },
                            method: "DELETE",
                            body: data,
                            mode: "cors",
                        });

                        const result = await request.json();

                        if (!request.ok) {
                            throw new Error(
                                `${result.message} - Code: ${result.code}`
                            );
                        }

                        if (result.success) {
                            loader.setAttribute("style", "display: none;");

                            Toastify({
                                text: result.message,
                                style: {
                                    background: "#198754",
                                },
                                duration: 3000,
                            }).showToast();

                            obtenerRoles();
                        }
                    } catch (error) {
                        loader.setAttribute("style", "display: none;");
                        Swal.fire("Ups!!", error.message, "error");
                    }
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    loader.setAttribute("style", "display: none;");
                    swalWithBootstrapButtons.fire(
                        "Cancelado",
                        "Operacion cancelada por el Usuario",
                        "error"
                    );
                }
            });
    }

    function limpiarRoles() {
        while (resulFetch.firstChild) {
            resulFetch.removeChild(resulFetch.firstChild);
        }
    }

    function limpiarPermisosAgregardos() {
        while (permisosAgregados.firstChild) {
            permisosAgregados.removeChild(permisosAgregados.firstChild);
        }
    }
});
