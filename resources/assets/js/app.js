require('./bootstrap');

Vue.component('emprestimos-grid', require('./components/Emprestimos.vue'));
Vue.component('criar-emprestimo', require('./components/CriarEmprestimo.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('form-livro', require('./components/FormLivro.vue'));

const app = new Vue({
    el: '#app'
});
