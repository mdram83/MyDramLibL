import './bootstrap';

import.meta.glob([
    './library/*.js',
    './library/ajax/*.js',
]);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
