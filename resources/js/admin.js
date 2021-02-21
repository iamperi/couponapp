require('./bootstrap');

require('alpinejs');
import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";

const dateInputOptions = {
    locale: Spanish,
    enableTime: true,
    dateFormat: 'd/m/Y H:i',
};
flatpickr('#ends_at', dateInputOptions)
flatpickr('#starts_at', Object.assign(dateInputOptions, {defaultDate: 'today'}));
