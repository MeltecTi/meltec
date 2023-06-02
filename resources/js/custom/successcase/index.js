"use strict";

document.addEventListener("DOMContentLoaded", () => {
    getSuccessCases();
});

const content = document.querySelector("#content");

const apiToken = document
    .querySelector('meta[name="api-token"]')
    .getAttribute("content");

const _token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

let cases = [];

const getSuccessCases = async () => {
    try {
        const url = `/api/successcases`;

        axios
            .get(url, {
                headers: {
                    Authorization: `Bearer ${apiToken}`,
                },
            })
            .then((response) => {
                if (response.data === "") {
                    clearDiv();
                    const textNocontent = document.createElement("P");
                    textNocontent.classList.add(
                        "text-center",
                        "text-capitalize",
                        "fs-3",
                        "mt-3"
                    );
                    textNocontent.textContent = `No se ha creado ningun registro!`;

                    content.appendChild(textNocontent);
                    return;
                } else {
                    cases = response.data.data;
                    constructData();
                    console.log(cases);
                }
            })
            .catch((error) => {
                console.error(error.message);
            });
    } catch (error) {
        console.error(error);
    }
};

const constructData = () => {
    clearDiv();
    cases.forEach((data) => {
        const {
            id,
            caseneed,
            caseSolution,
            caseResult,
            mark,
            image,
        } = data;

        const divCard = document.createElement("DIV");
        divCard.classList.add("card", "mb-3", "mt-3", "p-3");

        const divRowCard = document.createElement("DIV");
        divRowCard.classList.add("row", "no-gutters");

        const divImage = document.createElement("DIV");
        divImage.classList.add("col-md-4");

        const imageCard = document.createElement("IMG");
        imageCard.setAttribute("src", "");
        imageCard.setAttribute("alt", image);

        divImage.appendChild(imageCard);

        const divContentText = document.createElement("DIV");
        divContentText.classList.add("col-md-6");
        const divCardContentText = document.createElement("DIV");
        divCardContentText.classList.add("card-body");

        const h5Title = document.createElement('H5');
        h5Title.classList.add('card-title');
        h5Title.textContent = mark.name
        const ulistContent =document.createElement('UL');
        ulistContent.classList.add('list-group', 'list-group-flush');
        const li1ContentList = document.createElement('LI');
        li1ContentList.classList.add('list-group-item');
        li1ContentList.textContent = caseneed;
        const li2ContentList = document.createElement('LI');
        li2ContentList.classList.add('list-group-item');
        li2ContentList.textContent = caseSolution;
        const li3ContentList = document.createElement('LI');
        li3ContentList.classList.add('list-group-item');
        li3ContentList.textContent = caseResult;

        ulistContent.appendChild(li1ContentList);
        ulistContent.appendChild(li2ContentList);
        ulistContent.appendChild(li3ContentList);

        const buttonsDivOptions = document.createElement('DIV');
        buttonsDivOptions.classList.add('col-md-2', 'd-flex', 'pt-5', 'pb-5', 'aling-middle');
        const buttonEdit = document.createElement('BUTTON');
        buttonEdit.classList.add('btn', 'btn-info')
        buttonEdit.textContent = `Editar`;
        const buttonDelete = document.createElement('BUTTON');
        buttonDelete.classList.add('btn', 'btn-danger', 'me-md-2')
        buttonDelete.textContent = `Borrar`;

        buttonsDivOptions.appendChild(buttonEdit);
        buttonsDivOptions.appendChild(buttonDelete);

        divCardContentText.appendChild(h5Title);
        divCardContentText.appendChild(ulistContent);

        divContentText.appendChild(divCardContentText)

        divRowCard.appendChild(divImage);
        divRowCard.appendChild(divContentText);
        divRowCard.appendChild(buttonsDivOptions);

        divCard.appendChild(divRowCard);
        content.appendChild(divCard);
    });
};

const clearDiv = () => {
    while (content.firstChild) {
        content.removeChild(content.firstChild);
    }
};
