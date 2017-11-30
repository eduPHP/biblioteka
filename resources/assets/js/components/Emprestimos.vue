<template>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Emprestimos</h1>
                <h2 class="subtitle" v-if="filteredBy !== ''">
                    Filtrado por <span class="tag">
                        {{ filteredBy }}
                        <button class="delete is-small" @click="filteredBy = ''"></button>
                    </span>
                </h2>

            </div>
            <div class="level-right">
                <div class="control has-icons-right">
                    <input v-model="search" @keyup.enter="buscar" placeholder="Buscar..." class="input">
                    <span class="icon is-small is-right"><i class="fa fa-search"></i></span>
                </div>
                <a v-if="can('create-emprestimos')" @click="adicionar" class="button is-info ml-1">
                    <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
            </div>

        </div>
        <hr />
        <div class="has-text-centered" v-if="loading">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>
        </div>

        <table v-if="itens.length" class="table is-fullwidth crud">
            <thead>
            <tr>
                <th @click="orderBy('livro')">
                    <span>Livro</span> <span class="icon is-small" v-if="order.field === 'livro'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th @click="orderBy('estudante')">
                    <span>Estudante</span> <span class="icon is-small" v-if="order.field === 'estudante'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th @click="orderBy('devolucao')">
                    <span>Entrega</span> <span class="icon is-small" v-if="order.field === 'devolucao'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="emprestimo in itens">
                <td>
                    [ {{emprestimo.livro.isbn}} ] {{emprestimo.livro.titulo}}
                </td>
                <td>
                    {{emprestimo.estudante.nome}}
                </td>
                <td v-if="!emprestimo.devolvido">
                    {{ emprestimo.devolucao | forHumans | capitalize }}
                </td>
                <td colspan="2" v-if="emprestimo.devolvido">
                    Devolvido {{ emprestimo.devolvido_em | forHumans }}
                </td>
                <td class="has-buttons" v-else>
                    <div class="level" v-if="can('renew-emprestimos') || can('return-emprestimos')">
                        <a v-if="can('renew-emprestimos')" @click="renovar(emprestimo)" title="Renovar" class="button is-white level-left">
                            <i class="fa fa-recycle"></i> </a>
                        <button v-if="can('return-emprestimos')" @click="devolver(emprestimo)" title="Devolver" class="button is-white level-right">
                            <i class="fa fa-arrow-circle-o-down"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-if="!loading && !itens.length">Nenhum registro encontrado.</p>
        <paginator :meta="meta" @changed="fetch"></paginator>
        <confirm></confirm>
        <criar-emprestimo :active="editando" @close="close"></criar-emprestimo>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue";
    import Confirm from "../components/Confirm.vue";
    import indexGrid from "../mixins/indexGrid";

    let moment = require('moment');
    import 'moment/locale/pt-br';

    export default {
        mixins: [indexGrid],
        components: {Paginator, Confirm},
        data() {
            return {
                basePath: 'emprestimos'
            };
        },

        computed: {
            defaultOrder() {
                return {
                    field: 'devolucao',
                    direction: 'asc'
                };
            }
        },

        filters: {
            forHumans(data) {
                return moment(data).fromNow();
            },
            capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },

        methods: {
            adicionar(){
                this.editando = true;
            },
            close(refresh){
                this.editando = false;
                if (refresh === true){
                    this.fetch();
                }
            },
            renovar(emprestimo) {
                vueConfirm(()=>{
                    axios.post(`${this.paths.destroy(emprestimo)}/renovar`).then(response => {
                        emprestimo.devolucao = response.data.devolucao;
                        flash('Empréstimo renovado.', 'info')
                    });
                }, 'Renovar empréstimo?', 'Renovar', 'fa-recycle');
            },

            devolver(emprestimo) {
                vueConfirm(()=>{
                    axios.patch(`${this.paths.destroy(emprestimo)}/devolver`).then(() => {
                        emprestimo.devolvido = true;
                        emprestimo.devolvido_em = moment().format();
                        flash('Empréstimo devolvido.','info')
                    });
                }, 'Devolver livro?', 'Devolver', 'fa-arrow-circle-o-down');
            }
        }
    }
</script>

<style scoped>
    .level-left {
        display : block;
    }
</style>