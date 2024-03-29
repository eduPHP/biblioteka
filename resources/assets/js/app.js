require('./bootstrap');

Vue.component('emprestimos-grid', require('./components/Emprestimos.vue'));
Vue.component('autores-grid', require('./components/Autores.vue'));
Vue.component('estudantes-grid', require('./components/Estudantes.vue'));
Vue.component('editoras-grid', require('./components/Editoras.vue'));
Vue.component('secoes-grid', require('./components/Secoes.vue'));
Vue.component('livros-grid', require('./components/Livros.vue'));
Vue.component('criar-emprestimo', require('./components/forms/CriarEmprestimo.vue'));
Vue.component('relatorio-mais-emprestados', require('./components/RelatorioMaisEmprestados.vue'));
Vue.component('flash', require('./components/Flash.vue'));
import Auth from './directives/auth';

const app = new Vue({
    el: '#app',
    data: {
        menuOpen: false,
        auth: new Auth(window.User),
    },
    methods: {

        can(action){
            return this.auth.can(action);
        },
        logout(){
            axios.post('/logout').then(()=>{
                location.reload();
            }).catch(({data})=>{
                flash(data, 'erro');
            });
        },
        voltar(){
            window.history.back();
        }
    }
});
