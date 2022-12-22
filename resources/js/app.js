import './bootstrap';

import.meta.glob([
    '../js/library/**',
]);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
