import.meta.glob([
    'resources/js/library/ajax/*.js',
]);

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
