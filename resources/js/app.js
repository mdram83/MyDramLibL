const modules = import.meta.glob('./library/ajax/isbn-details.js');

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
