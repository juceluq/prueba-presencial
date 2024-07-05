import esLocale from "@fullcalendar/core/locales/es";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "boxicons";

document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("calendar");
    let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
        allDaySlot: false,
        nowIndicator: true,
        businessHours: [
            {
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: "09:00:00",
                endTime: "13:30:00",
            },
            {
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: "15:30:00",
                endTime: "21:30:00",
            },
        ],
        weekends: false,
        slotMinTime: "09:00:00",
        slotMaxTime: "21:30:00",
        initialView: "timeGridWeek",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        locale: esLocale,
        slotLabelInterval: "00:30:00",
        slotLabelFormat: {
            hour: "2-digit",
            minute: "2-digit",
        },
        height: "auto",
        events: "/apiGetEventos",
    });
    calendar.render();
});
