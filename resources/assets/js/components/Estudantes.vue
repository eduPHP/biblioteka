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
                <div class="control has-icons-right">
                    <input v-model="search" @keyup.enter="buscar" placeholder="Buscar..." class="input">
                    <span class="icon is-small is-right"><i class="fa fa-search"></i></span>
                </div>
                <a v-if="can('create-estudantes')" @click="editar" class="button is-info ml-1">
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
                <th @click="orderBy('matricula')" class="is-74">
                    <span>Matrícula</span> <span class="icon is-small" v-if="order.field === 'matricula'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th @click="orderBy('nome')">
                    <span>Nome</span> <span class="icon is-small" v-if="order.field === 'nome'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th v-if="can('edit-estudantes') || can('delete-estudantes')" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="estudante in itens">
                <td>
                    {{estudante.matricula}}
                </td>
                <td>
                    {{estudante.nome}}
                </td>
                <td v-if="can('edit-estudantes') || can('delete-estudantes')" class="has-buttons">
                    <div class="level">
                        <a v-if="can('edit-estudantes')" @click="editar(estudante)" title="Editar" class="button is-info level-left">
                            <i class="fa fa-pencil"></i> </a>
                        <button v-if="can('delete-estudantes')" @click="remover(estudante)" title="Remover" class="button is-danger level-right">
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
        <form-estudante :estudante="editResource" :active="editando" @close="fecharEdicao($event)"></form-estudante>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue";
    import Confirm from "../components/Confirm.vue";
    import FormEstudante from "../components/forms/FormEstudante.vue";
    import indexGrid from "../mixins/indexGrid";

    export default {
        mixins: [indexGrid],
        components: {Paginator, Confirm, FormEstudante},
        data() {
            return {
                basePath: 'estudantes'
            };
        },

        methods: {
            remover(estudante) {
                vueConfirm(() => {
                    axios.delete(this.paths.destroy(estudante)).then(() => {
                        flash('Estudante removido.', 'info');
                        this.fetch()
                    });
                }, 'Remover estudante?', 'Excluir', 'fa-trash');
            }
        }
    }
</script>

<style scoped>
    .level-left {
        display : block;
    }

    .is-74 {
        width : 7.4rem;
    }
</style>