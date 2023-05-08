'use strict';
document.addEventListener('DOMContentLoaded', () => {
    const dinamicDate = document.querySelector('#dinamicDate');
    const today = new Date();

    dinamicDate.textContent = today.toLocaleDateString('es-CO', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });

})