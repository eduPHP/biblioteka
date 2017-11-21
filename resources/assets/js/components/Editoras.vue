<template>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Editoras</h1>
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
                <a @click="editar" class="button is-info">
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
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="editora in itens">
                <td>
                    {{editora.nome}}
                </td>
                <td class="has-buttons">
                    <div class="level">
                        <a @click="editar(editora)" title="Editar" class="button is-info level-left">
                            <i class="fa fa-pencil"></i> </a>
                        <button @click="remover(editora)" title="Remover" class="button is-danger level-right">
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
        <form-editora :editora="editResource" :active="editando" @close="fecharEdicao($event)"></form-editora>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue";
    import Confirm from "../components/Confirm.vue";
    import indexGrid from "../mixins/indexGrid";
    import FormEditora from "../components/forms/FormEditora.vue";

    export default {
        mixins: [indexGrid],
        components: {Paginator, Confirm, FormEditora},
        data() {
            return {
                basePath: 'editoras'
            };
        },

        methods: {
            remover(editora) {
                vueConfirm(() => {
                    axios.delete(this.paths.destroy(editora)).then(() => {
                        flash('Editora removida.', 'info')
                        this.fetch()
                    });
                }, 'Remover editora?', 'Excluir', 'fa-trash');
            }
        }
    }
</script>

<style scoped>
    .level-left {
        display : block;
    }
</style>