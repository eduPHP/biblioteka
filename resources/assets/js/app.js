require('./bootstrap');

Vue.component('emprestimos-grid', require('./components/Emprestimos.vue'));
Vue.component('autores-grid', require('./components/Autores.vue'));
Vue.component('estudantes-grid', require('./components/Estudantes.vue'));
Vue.component('editoras-grid', require('./components/Editoras.vue'));
Vue.component('secoes-grid', require('./components/Secoes.vue'));
Vue.component('livros-grid', require('./components/Livros.vue'));
Vue.component('criar-emprestimo', require('./components/CriarEmprestimo.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('form-livro', require('./components/FormLivro.vue'));

const app = new Vue({
    el: '#app'
});
