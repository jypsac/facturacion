
require('./bootstrap');

window.Vue = require('vue');



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('invoice-compra-component', require('./components/InvoiceCreateCompra.vue').default);


const app = new Vue({
    el: '#app',
});


