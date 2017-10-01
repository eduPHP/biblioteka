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
                <div class="control has-icons-right mr-1">
                    <input v-model="search" @keyup.enter="buscar" placeholder="Buscar..." class="input">
                    <span class="icon is-small is-right"><i class="fa fa-search"></i></span>
                </div>
                <a href="/emprestimos/create" class="button is-info">
                    <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
            </div>

        </div>

        <div class="has-text-centered" v-if="loading">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>
        </div>

        <table v-if="emprestimos.length" class="table is-fullwidth crud">
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
            <tr v-for="emprestimo in emprestimos">
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
                    <div class="level">
                        <a @click="renovar(emprestimo)" title="Renovar" class="button is-white level-left">
                            <i class="fa fa-recycle"></i> </a>
                        <button @click="devolver(emprestimo)" title="Devolver" class="button is-white level-right">
                            <i class="fa fa-arrow-circle-o-down"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-if="!loading && !emprestimos.length">Nenhum registro encontrado.</p>
        <paginator :meta="meta" @changed="fetch"></paginator>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue";

    let moment = require('moment');
    import 'moment/locale/pt-br';


    export default {
        components: {Paginator},
        replace: true,
        data() {
            return {
                search: '',
                filteredBy: '',
                loading: false,
                meta: {},
                order: {
                    field: 'devolucao',
                    direction: 'asc'
                },
                emprestimos: []
            };
        },

        watch: {
            filteredBy() {
                this.search = '';
                this.fetch(this.filteredBy === '' ? 1 : null);
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
            buscar() {
                this.filteredBy = this.search;
            },

            orderBy(field) {
                let direction = this.order.direction === 'asc' && this.order.field === field ? 'desc' : 'asc';

                this.order = {
                    field,
                    direction
                };
                this.fetch(1);
            },

            renovar(emprestimo) {
                axios.post(`/api/emprestimos/${emprestimo.id}/renovar`).then(response => {
                    console.log(response);
                    emprestimo.devolucao = response.data.devolucao;
                });
            },

            devolver(emprestimo) {
                axios.patch(`/api/emprestimos/${emprestimo.id}/devolver`).then(response => {
                    console.log(response);
                    emprestimo.devolvido = true;
                    emprestimo.devolvido_em = moment().format();
                });
            },

            fetch(page) {
                if (this.loading) {
                    return;
                }
                let query = [];
                if (!page) {
                    let pageInQuery = location.search.match(/page=(\d+)/);
                    page = pageInQuery ? parseInt(pageInQuery[1]) : 1;
                }
                if (page > 1) query.push(`page=${page}`);

                query.push(`orderby=${this.order.field},${this.order.direction}`);
                if (this.filteredBy !== '') {
                    query.push(`q=${this.filteredBy}`);
                }

                this.loading = true;
                axios.get('/api/emprestimos?' + query.join('&')).then(response => {
                    console.log(response.data);
                    this.emprestimos = response.data.emprestimos;
                    this.meta = response.data.meta;
                    this.loading = false;
                });
                this.updateLocation(query);
            },

            updateLocation(query) {
                let update = query.join('&');
                if (update === 'orderby=devolucao,asc') {
                    history.pushState(null, document.title, location.href.split("?")[0]);
                    return;
                }

                history.pushState(null, document.title, '?' + update);
            }
        },
        mounted() {
            let searchInQuery = location.search.match(/q=([^&]+)/);
            let orderInQuery = location.search.match(/orderby=([a-z]+),(asc|desc)/);
            if (orderInQuery) {
                this.order = {
                    field: orderInQuery[1],
                    direction: orderInQuery[2]
                };
            }
            if (searchInQuery) {
                this.filteredBy = searchInQuery[1];
                return;
            }
            this.fetch();
        }
    }
</script>

<style>
    .level-left {
        display : block;
    }
</style>