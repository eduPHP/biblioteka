require('./bootstrap');

Vue.component('emprestimos-grid', require('./components/Emprestimos.vue'));
Vue.component('criar-emprestimo', require('./components/CriarEmprestimo.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('bulma-select', require('./components/Select.vue'));

const app = new Vue({
    el: '#app',
    data: {
        autores: [],
        autor: null
    },
    methods:{
        searchAutor(query){
            if (!query.length){
                return;
            }
            axios.get(`/api/autores?q=${query}`).then(({data}) => this.autores = data.autores);
        }
    }
});
