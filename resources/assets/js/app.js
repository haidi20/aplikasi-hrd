
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.$ = window.jQuery = require('jquery');
window.select2 = require('select2');

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
*/

require('@fengyuanchen/datepicker');
require('select2');

$(document).ready(function() {
    $('.select2').select2();
});

/* Datepicker */
$.fn.datepicker.setDefaults({
    format: 'dd/mm/yyyy',
    autoHide: true,
    days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'],
    daysShort: ['Mng', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
    daysMin: ['Mg', 'Sn', 'Se', 'Ra', 'Ka', 'Ju', 'Sa'],
    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
})

$('[data-toggle="datepicker"]').datepicker();
