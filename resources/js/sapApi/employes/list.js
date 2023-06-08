"use strict";

import axios from "axios";
import DataTable from "datatables.net-bs5";

document.addEventListener("DOMContentLoaded", () => {
    getEmployesBySAP();
});

const apiToken = document
    .querySelector('meta[name="api-token"]')
    .getAttribute("content");

let employes = [];

const getEmployesBySAP = async () => {
    try {
        const url = `/api/empleadosSAP`;
        axios
            .get(url, {
                headers: {
                    Authorization: `Bearer: ${apiToken}`,
                },
            })
            .then((result) => {
                const quantityEmployes =
                    document.querySelector("#quantityEmployes");

                employes = result.data;
                quantityEmployes.textContent = `Se encontraron ${employes.length} Empleados registrados en total`;
                constructData(employes);
            })
            .catch((err) => {
                console.error(err);
            });
    } catch (error) {
        console.error(error);
    }
};

const constructData = (employes) => {
    const tableConstruct = document.querySelector("#tableConstruct");
    const tbody = tableConstruct.getElementsByTagName("tbody")[0];

    employes.forEach((person) => {
        const {
            EmployeeID,
            BirthPlaceName,
            BusinessPartnerFormattedName,
            ObjectID,
            EmployeeEmployeePrivateAddressInformation,
        } = person;

        // Construccion de la tabla
        const tr = document.createElement("TR");

        const tdimage = document.createElement("TD");
        tdimage.classList.add("py-1", "p-3");
        const image = document.createElement("IMG");
        image.setAttribute("src", `/storage/employesImg/default.png`);
        image.setAttribute("alt", "ImagePerson");

        tdimage.appendChild(image);

        const tdNamePerson = document.createElement("TD");
        const divGeneral = document.createElement("DIv");
        divGeneral.classList.add("d-flex");

        const divName = document.createElement("DIV");
        const h6Name = document.createElement("H6");
        h6Name.textContent = BusinessPartnerFormattedName;

        divName.appendChild(h6Name);
        divGeneral.appendChild(divName);
        tdNamePerson.appendChild(divGeneral);

        const tdIdentification = document.createElement("TD");
        const h6Identification = document.createElement("H6");
        h6Identification.textContent = EmployeeID;

        tdIdentification.appendChild(h6Identification);

        const tdRegionEmploye = document.createElement("TD");
        const h6Region = document.createElement("H6");
        h6Region.textContent = BirthPlaceName;
        tdRegionEmploye.appendChild(h6Region);

        let email = "";
        if (EmployeeEmployeePrivateAddressInformation) {
            email = EmployeeEmployeePrivateAddressInformation.URI;
        } else {
            email = "No se registraron datos";
        }

        const tdEmailEmployee = document.createElement("TD");
        const emailEmploye = document.createElement("P");
        emailEmploye.textContent = email;
        tdEmailEmployee.appendChild(emailEmploye);

        const tdOptions = document.createElement("TD");
        const divTdOptions = document.createElement("DIV");
        divTdOptions.classList.add("d-grid", "gap-2", "d-md-block");

        const buttonView = document.createElement("BUTTON");
        buttonView.classList.add(
            "btn",
            "btn-inverse-success",
            "btn-icon",
            "btn-md"
        );
        buttonView.setAttribute("type", "button");
        buttonView.innerHTML = `<i class="ti-location-pin"></i>`;

        // Evento del boton
        buttonView.addEventListener("click", (e) => {

            e.preventDefault();
            
            const uuidEmployed = ObjectID;
            employe(uuidEmployed);
        });

        divTdOptions.appendChild(buttonView);

        tdOptions.appendChild(divTdOptions);

        tr.appendChild(tdimage);
        tr.appendChild(tdNamePerson);
        tr.appendChild(tdIdentification);
        tr.appendChild(tdRegionEmploye);
        tr.appendChild(tdEmailEmployee);
        tr.appendChild(tdOptions);

        tbody.appendChild(tr);
        // console.log(person);
    });

    let datatables = new DataTable(tableConstruct, {
        language: {
            lengthMenu: "Mostrado _MENU_ Resultados por pagina",
            zeroRecords: "Ningun Registro Encontrado",
            info: "Pagina _PAGE_ de _PAGES_",
            infoEmpty: "No se encontraron registros",
            infoFiltered: "(Total de Empleados _MAX_ )",
        },
    });
};

const checkExistImage = (imageUrl, callback) => {
    const img = new Image();
    img.onload = () => {
        callback(true);
    };

    img.onerror = () => {
        callback(false);
    };

    img.src = imageUrl;
};

const clearDiv = () => {
    while (tableConstruct.firstChild) {
        tableConstruct.removeChild(tableConstruct.firstChild);
    }
};

const employe = async (uuid) => {
    console.log(uuid);

    const modal = new bootstrap.Modal(
        document.querySelector("#vieworeditData")
    );
    modal.show();
};
