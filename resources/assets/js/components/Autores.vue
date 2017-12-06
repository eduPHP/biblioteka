<template>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Autores</h1>
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
                <a v-if="can('create-autores')" @click="editar({nome:''})" class="button is-info ml-1">
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
                <th @click="orderBy('nome')">
                    <span>Nome</span> <span class="icon is-small" v-if="order.field === 'nome'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th @click="orderBy('livros-count','desc')" class="is-2">
                    <span># Livros</span> <span class="icon is-small" v-if="order.field === 'livros-count'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th v-if="can('edit-autores') || can('delete-autores')" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="autor in itens">
                <td>
                    {{autor.nome}}
                </td>
                <td>
                    {{autor.livros_count}}
                </td>
                <td v-if="can('edit-autores') || can('delete-autores')" class="has-buttons">
                    <div class="level">
                        <a v-if="can('edit-autores')" @click="editar(autor)" title="Editar" class="button is-info level-left">
                            <i class="fa fa-pencil"></i> </a>
                        <button v-if="can('delete-autores')" @click="remover(autor)" title="Remover" class="button is-danger level-right">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-if="!loading && !itens.length">Nenhum registro encontrado.</p>
        <paginator :meta="meta" @changed="fetch"></paginator>
        <confirm></confirm>
        <form-autor :autor="editResource" :active="editando" @close="fecharEdicao($event)"></form-autor>
    </div>
</template>

<script>
    import FormAutor from "../components/forms/FormAutor.vue";
    import indexGrid from "../mixins/indexGrid";
    import Confirm from "../components/Confirm.vue";
    import Paginator from "../components/Paginator.vue";

    export default {
        mixins: [indexGrid],
        components: {Paginator, Confirm, FormAutor},
        data() {
            return {
                basePath: 'autores'
            };
        },

        methods: {
            remover(autor) {
                vueConfirm(() => {
                    axios.delete(this.paths.destroy(autor)).then(() => {
                        flash('Autor removido.', 'info');
                        this.fetch();
                    });
                }, 'Remover autor?', 'Excluir', 'fa-trash');
            }
        }
    }
</script>

<style scoped>
    .level-left {
        display : block;
    }
</style>