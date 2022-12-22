import './bootstrap';

import.meta.glob([
    '../js/library/ajax/**',
]);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
