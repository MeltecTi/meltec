"use strict";

document.addEventListener('DOMContentLoaded', () => {
    ClassicEditor.create(document.querySelector("#contentBlog"))
        .then((editor) => {
            editor.model.document.on("change:data", () => {
                const contenidos = document.querySelector("textarea#contentBlog");
                contenidos.value = editor.getData();
            });
        })
        .catch((error) => {
            console.log(error);
        });

})
