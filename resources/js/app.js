import "./requires/bootstrap";
import * as bootstrap from 'bootstrap';
import $ from 'jquery';


window.onload = () => {
    const spiner = document.querySelector("#spinner");
    const container = document.querySelector("#containerAll");

    setTimeout(() => {
        spiner.style.visibility = "hidden";
        container.style.opacity = 1;
    }, 1000);
};
