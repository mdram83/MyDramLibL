import.meta.glob([
    '../js/library/**',
    '../js/library/ajax/**',
]);

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
