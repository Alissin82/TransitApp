import axios from 'axios';
import toastr from 'toastr';

import ApexCharts from 'apexcharts';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
// FullCalendar
import { Calendar } from '@fullcalendar/core';

import collapse from '@alpinejs/collapse'

window.axios = axios;
window.toastr = toastr;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

document.addEventListener('livewire:init', () => {
    Alpine.plugin(collapse)
})
