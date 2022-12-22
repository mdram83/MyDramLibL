import './bootstrap';

import.meta.glob([
    '../js/library/ajax/isbn-details.js',
    // './library/*.js',
    // './library/ajax/*.js',
]);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
