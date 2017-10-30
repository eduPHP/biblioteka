require('./bootstrap');

Vue.component('emprestimos-grid', require('./components/Emprestimos.vue'));
Vue.component('criar-emprestimo', require('./components/CriarEmprestimo.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('select-autores', require('./components/SelectAutores.vue'));
Vue.component('select-editoras', require('./components/SelectEditoras.vue'));
Vue.component('select-secoes', require('./components/SelectSecoes.vue'));

const app = new Vue({
    el: '#app'
});
