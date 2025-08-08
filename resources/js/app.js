import './bootstrap';
import 'livewire-sortable'
import interact from 'interactjs';
window.interact = interact;
import domtoimage from 'dom-to-image-more';
window.domtoimage = domtoimage;
import html2pdf from 'html2pdf.js';
window.html2pdf = html2pdf;
import ApexCharts from 'apexcharts'
window.ApexCharts = ApexCharts;
// import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.focus = focus;


import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
window.flatpickr = flatpickr;


import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.interactionPlugin = interactionPlugin;


import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
window.tippy = tippy;
// import focus from '@alpinejs/focus';

// // Register the focus plugin


// window.focus = focus;
// const interact = require('interact-js');
// import Alpine from 'alpinejs'

// window.Alpine = Alpine

// Alpine.start()
