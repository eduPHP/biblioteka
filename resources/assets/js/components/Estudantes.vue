<template>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Estudantes</h1>
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
                <a href="/estudantes/create" class="button is-info">
                    <span class="icon"><i class="fa fa-plus"></i></span> <span>Adicionar</span> </a>
            </div>

        </div>
        <hr />
        <div class="has-text-centered" v-if="loading">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>
        </div>

        <table v-if="estudantes.length" class="table is-fullwidth crud">
            <thead>
            <tr>
                <th @click="orderBy('nome')">
                    <span>Nome</span> <span class="icon is-small" v-if="order.field === 'nome'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="estudante in estudantes">
                <td>
                    {{estudante.nome}}
                </td>
                <td class="has-buttons">
                    <div class="level">
                        <a :href="estudante | editUrl" title="Editar" class="button is-info level-left">
                            <i class="fa fa-pencil"></i> </a>
                        <button @click="remover(estudante)" title="Remover" class="button is-danger level-right">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-if="!loading && !estudantes.length">Nenhum registro encontrado.</p>
        <paginator :meta="meta" @changed="fetch"></paginator>
        <confirm></confirm>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue";
    import Confirm from "../components/Confirm.vue";
    import indexGrid from "../mixins/indexGrid";

    export default {
        mixins: [indexGrid],
        components: {Paginator, Confirm},
        data() {
            return {
                order: {
                    field: 'nome',
                    direction: 'asc'
                },
                estudantes: []
            };
        },

        filters: {
            editUrl(estudante){
                return `/estudantes/${estudante.id}/edit`;
            }
        },

        methods: {
            remover(estudante) {
                vueConfirm(() => {
                    axios.delete(`/api/estudantes/${estudante.id}`).then(() => {
                        flash('Autor removido.', 'info')
                        this.fetch()
                    });
                }, 'Remover estudante?', 'Excluir', 'fa-trash');
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
                axios.get('/api/estudantes?' + query.join('&')).then(response => {
                    this.estudantes = response.data.estudantes;
                    this.meta = response.data.meta;
                    this.loading = false;
                });
                this.updateLocation(query);
            },
            updateLocation(query) {
                let update = query.join('&');
                if (update === 'orderby=nome,asc') {
                    history.pushState(null, document.title, location.href.split("?")[0]);
                    return;
                }

                history.pushState(null, document.title, '?' + update);
            }
        }
    }
</script>

<style scoped>
    .level-left {
        display : block;
    }
</style>