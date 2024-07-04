import esLocale from '@fullcalendar/core/locales/es';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'boxicons';


let calendarEl = document.getElementById('calendar');
let calendar = new Calendar(calendarEl, {
  plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
  initialView: 'dayGridMonth',
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,listWeek'
  },
  initialView: 'timeGridWeek',
        locale: esLocale,
        themeSystem: 'bootstrap5' ,
        slotLabelInterval: '00:30:00',
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
        },
});
calendar.render();