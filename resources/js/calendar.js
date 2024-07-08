import esLocale from "@fullcalendar/core/locales/es";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "boxicons";

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("delete-form");
    let calendarEl = document.getElementById("calendar");
    let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        allDaySlot: false,
        nowIndicator: true,
        selectable: true,
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
        eventClick: function (info) {
            $("#edit_id").val(info.event.id);
            $("#edit_tipo_id").val(info.event.extendedProps.tipo_evento_id);
            $("#edit_titulo").val(info.event.title);
            $("#delete_id").val(info.event.id);
            $("#modalEditEvent").modal("show");
            $("#edit_startDate").val(
                new Date(info.event.start.getTime() + 2 * 60 * 60 * 1000)
                    .toISOString()
                    .substring(0, 16)
            );
            $("#edit_endDate").val(
                new Date(info.event.end.getTime() + 2 * 60 * 60 * 1000)
                    .toISOString()
                    .substring(0, 16)
            );
            var selectTipoEvento =
                document.getElementById("choose_tipo_evento");

            for (var i = 0; i < selectTipoEvento.options.length; i++) {
                if (
                    selectTipoEvento.options[i].value ==
                    info.event.extendedProps.tipo_evento_id
                ) {
                    selectTipoEvento.options[i].selected = true;
                } else {
                    selectTipoEvento.options[i].selected = false;
                }
            }
        },
        select: function (info) {
            $("#modalAddEvent").modal("show");
            $("#add_startDate").val(
                new Date(new Date(info.start).getTime() + 2 * 60 * 60 * 1000)
                    .toISOString()
                    .substring(0, 16)
            );
            $("#add_endDate").val(
                new Date(new Date(info.end).getTime() + 2 * 60 * 60 * 1000)
                    .toISOString()
                    .substring(0, 16)
            );
        },
    });
    calendar.render();

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const deleteId = document.getElementById("delete_id").value;
        if (deleteId) {
            const action = form.action.replace("reemplazar", deleteId);
            form.action = action;
            form.submit();
        } else {
            alert("El ID a eliminar no puede estar vacío.");
        }
    });
});
