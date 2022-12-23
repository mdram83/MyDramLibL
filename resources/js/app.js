const modules = import.meta.glob('./library/**/*.js');
console.log(modules);

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
