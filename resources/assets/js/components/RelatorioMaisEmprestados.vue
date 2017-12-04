<template>

    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Livros mais emprestados</h1>
                <h2 class="subtitle" v-if="filtered">
                    No período entre <span class="tag">
                        {{ dataInicial | parseDate }} e {{ dataFinal | parseDate }}
                        <button class="delete is-small" @click="removeFilterDate"></button>
                    </span>
                </h2>

            </div>
            <div class="level-right flex-1 level">
                <!-- Input Start -->
                <div class="field level-left" style="margin-bottom: 0; max-width: 13rem">
                    <datepick
                            placeholder="Data Inicial"
                            :date.sync="dataInicial"
                            @changed="dataInicial = $event"
                    ></datepick>
                </div>

                <!-- Input Start -->
                <div class="field level-right" style="margin-bottom: 0;margin-left: .5rem; max-width: 13rem">
                    <datepick
                            placeholder="Data Final"
                            :date.sync="dataFinal"
                            @changed="dataFinal = $event"
                    ></datepick>
                </div>
                <div class="level-right" style="margin-left: .5rem; ">
                    <button class="button" @click="filterDate"><i class="fa fa-filter"></i></button>
                </div>
                <div class="level-right" style="margin-left: .5rem; ">
                    <button class="button" @click="openDownload"><i class="fa fa-print"></i></button>
                </div>
            </div>
        </div>
        <hr>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th class="is-1" @click="orderBy('emprestimos','desc')">
                        <span># Emp.</span> <span class="icon is-small" v-if="order.field === 'emprestimos'">
                           <i class="fa" :class="order.direction === 'asc' ? 'fa-angle-up':'fa-angle-down'" aria-hidden="true"></i>
                        </span>
                    </th>
                    <th>Titulo</th>
                    <th class="has-text-right">Entre</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="itens.length" v-for="livro in itens">
                    <td>{{ livro.emprestimos_count }}</td>
                    <td>
                        {{ livro.titulo }}
                    </td>
                    <td class="has-text-right">
                        {{ livro.primeiro_emprestimo | parseDate }} &hyphen;
                        {{ livro.ultimo_emprestimo | parseDate }}
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="4" class="espaco">Nenhum Livro encontrado</td>
                </tr>
            </tbody>
        </table>
        <div>
            <paginator :meta="meta" @changed="fetch"></paginator>
        </div>
    </div>
</template>

<script>
    import Paginator from "../components/Paginator.vue"
    import Confirm from "../components/Confirm.vue"
    import Datepick from '../components/Datepicker.vue'
    import indexGrid from "../mixins/indexGrid"
    import moment from 'moment'
    import 'moment/locale/pt-br'

    export default {
        name: 'relatorio-mais-emprestados',
        mixins: [indexGrid],
        components: {Paginator, Confirm, Datepick},
        data(){
            return {
                basePath: 'livros',
                dataInicial: null,
                dataFinal: null,
                query: [],
                filtered: false
            }
        },

        computed: {
            defaultOrder() {
                return {
                    field: 'emprestimos',
                    direction: 'desc'
                }
            },

            indexPath(){
                return '/api/relatorios/mais-emprestados'
            },

            defaultQuery(){
                return this.query
            }
        },

        filters:{
            parseDate(date){
                return moment(date, "YYYY-MM-DD").format("DD/MM/YYYY")
            }
        },

        methods: {

            filterDate() {
                let inicio = moment(this.dataInicial).format('DD/MM/YYYY');
                let final = moment(this.dataFinal).format('DD/MM/YYYY');
                this.query.add('periodo',`${inicio},${final}`);
                this.filtered = true;
                this.fetch();
            },

            removeFilterDate(){
                this.dataInicial = this.dataFinal = null;
                this.filtered = false;
                this.query.remove('periodo');
                this.fetch();
            },

            openDownload() {
                window.open(`/relatorios/mais-emprestados/download${window.location.search}`)
            },

        },
        mounted(){
            if (this.query.has('periodo')){
                let periodo = this.query.match('periodo', /([\d\/]+),([\d\/]+)/);

                this.dataInicial = moment(periodo[1], "DD/MM/YYYY").toDate();
                this.dataFinal = moment(periodo[2], "DD/MM/YYYY").toDate();
                this.filtered = true;
                this.query.add('periodo',`${periodo[1]},${periodo[2]}`)
            }
        }
    }
</script>
<style>
    .vdp-datepicker__calendar-button{
        color            : #dbdbdb;
        height           : 2.25em;
        pointer-events   : none;
        position         : absolute;
        top              : 0;
        width            : 2.25em;
        z-index          : 4;
        align-items      : center;
        display          : inline-flex;
        justify-content  : center;
    }

    .level-left {
        display : block;
    }
</style>