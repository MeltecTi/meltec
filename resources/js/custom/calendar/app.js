"use strict";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from "@fullcalendar/list";
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import esLocale from '@fullcalendar/core/locales/es';
import multiMonthPlugin from '@fullcalendar/multimonth';

document.addEventListener("DOMContentLoaded", () => {
    const calendar = document.querySelector("#calendar");
    let calendarJs = new Calendar(calendar, {
        themeSystem: 'bootstrap5',
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,listWeek",
        },
        locale: esLocale,
        dateClick: (info) => {
            console.log(info);
            const modal = document.querySelector('#eventModal');

            const myModal = new bootstrap.Modal(modal);
            myModal.show();
        },
        aspectRatio: 3
    });
    calendarJs.render();
});
