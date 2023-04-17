'use strict';
document.addEventListener('DOMContentLoaded', () => {
    const slug = document.querySelector('#slug');
    const namePage = document.querySelector('#namePage');

    slug.setAttribute('readonly', true);

    namePage.addEventListener('blur', (e) => {
        const base = e.target.value.trim();
        const replaceslug = base.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/ /g, "-").replace(/ñ/gi, "n").toLowerCase();
        slug.value = replaceslug;
        
    })

    ClassicEditor.create(document.querySelector('#contentBlog'))
        .then((editor) => {
            editor.model.document.on('change:data', () => {
                const contenidos = document.querySelector("textarea#contentBlog");
                contenidos.value = editor.getData();
            })
        })
        .catch((error) => {
            console.error(error);
        });

    
    
});