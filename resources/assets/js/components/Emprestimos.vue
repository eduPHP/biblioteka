<template>
    <div class="container">
        Search <input v-model="search" @keyup.enter="buscar">
        <table v-if="emprestimos.length" class="table is-fullwidth">
            <thead>
            <tr>
                <th @click="orderBy('livro')">Livro</th>
                <th @click="orderBy('estudante')">Estudante</th>
                <th @click="orderBy('devolucao')">Entrega</th>
                <th>Ação</th>
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
                <td>
                    {{ emprestimo.devolvido ? 'Devolvido' : emprestimo.devolucao}}
                </td>
                <td v-if="emprestimo.devolvido">
                    -
                </td>
                <td v-else>
                    <a @click="renovar(emprestimo)" title="Renovar" class="button is-info is-small">
                        <i class="fa fa-recycle"></i> </a>
                    <a @click="devolver(emprestimo)" title="Devolver" class="button is-danger is-small">
                        <i class="fa fa-arrow-circle-o-down"></i> </a>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-else>Nenhum registro encontrado.</p>
        <nav class="pagination" role="navigation" aria-label="pagination" v-if="lastPage>1">
            <a class="pagination-previous" title="This is the first page" disabled v-if="page===1">Anterior</a>
            <a @click="page--" rel="prev" class="pagination-previous" v-else>Anterior</a>

            <a @click="page++" rel="next" class="pagination-next" v-if="page < lastPage">Próxima</a>
            <a class="pagination-next" title="This is the last page" disabled v-else>Próxima</a>
        </nav>
    </div>
</template>

<script>
    export default {
        replace: true,
        data() {
            return {
                search: '',
                page: 1,
                lastPage: 1,
                order: {
                    field: 'devolucao',
                    direction: 'desc'
                },
                emprestimos: []
            };
        },
        watch: {
            page() {
                this.reload();
            }
        },
        methods: {
            buscar() {
                this.reload();
                this.search = '';
            },

            orderBy(field) {
                let direction = this.order.direction === 'asc' && this.order.field === field ? 'desc' : 'asc';

                this.order = {
                    field,
                    direction
                };
                this.page = 1;
                this.reload();
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
                });
            },
            reload() {
                let vue = this;
                let query = `/api/emprestimos?page=${this.page}&orderby=${this.order.field},${this.order.direction}`;
                query += this.search === '' ? '' : `&q=${this.search}`;
                axios.get(query).then(response => {
                    console.log(response.data);
                    vue.emprestimos = response.data.emprestimos;
                    vue.lastPage = response.data.meta.last_page;
                });

                if (this.page > 1){
                    history.pushState(null, null, '?page=' + this.page);
                } else {
                    history.pushState(null, null, location.href.split("?")[0]);
                }
            }
        },
        mounted() {
            this.reload();
        }
    }
</script>
