<template>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Seções</h1>
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
                <a v-if="can('create-secoes')" @click="editar()" class="button is-info ml-1">
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
                <th @click="orderBy('descricao')">
                    <span>Descrição</span> <span class="icon is-small" v-if="order.field === 'descricao'">
                       <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                    </span>
                </th>
                <th v-if="can('edit-secoes') || can('delete-secoes')" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="secao in itens">
                <td>
                    {{secao.descricao}}
                </td>
                <td v-if="can('edit-secoes') || can('delete-secoes')" class="has-buttons">
                    <div class="level">
                        <a v-if="can('edit-secoes')" @click="editar(secao)" title="Editar" class="button is-info level-left">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <button v-if="can('delete-secoes')" @click="remover(secao)" title="Remover" class="button is-danger level-right">
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
        <form-secao :secao="editResource" :active="editando" @close="fecharEdicao($event)"></form-secao>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue";
    import Confirm from "../components/Confirm.vue";
    import indexGrid from "../mixins/indexGrid";
    import FormSecao from "../components/forms/FormSecao.vue"

    export default {
        mixins: [indexGrid],
        components: {Paginator, Confirm, FormSecao},
        data() {
            return {
                basePath: 'secoes'
            };
        },

        computed: {
            defaultOrder() {
                return {
                    field: 'descricao',
                    direction: 'asc'
                };
            }
        },

        methods: {
            remover(secao) {
                vueConfirm(() => {
                    axios.delete(this.paths.destroy(secao)).then(() => {
                        flash('Seção removida.', 'info')
                        this.fetch()
                    });
                }, 'Remover seção?', 'Excluir', 'fa-trash');
            }
        }
    }
</script>

<style scoped>
    .level-left {
        display : block;
    }
</style>