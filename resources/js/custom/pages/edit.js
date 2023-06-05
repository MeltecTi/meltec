"use strict";

document.addEventListener("DOMContentLoaded", () => {

    let productId = 0;

    idProduct(productId);

    console.log(idProduct(productId));
});

const idProduct = (productId) => {
    const url = window.location.href;

    const parts = url.split('/');

    const index = parts.indexOf('menus');

    if(index !== -1 && parts[index + 1]) {
        productId = parts[index + 1 ];
        return productId;
    } else {
        console.log('No existe codigo');
        return productId;
    }
}