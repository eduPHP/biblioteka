<template>
    <div>
        <div class="select2-multi">
            <div class="input-addon">
                <span class="tag is-large tag-default" v-if="selected" :class="{'is-success':!selected.id}">
                    <i class="fa fa-plus" v-if="!selected.id"> </i>
                    {{ selected.descricao }} <a class="delete is-small" @click="unselect"></a>
                </span>
            </div>
            <input class="input" v-if="!selected" @blur="close" @focus="open"
                   id="secao_id"
                   @keyup="search(1, $event)"
                   @keydown.down.prevent="typeAheadDown"
                   @keydown.up.prevent="typeAheadUp"
                   @keydown.esc.prevent="typeAheadEscape"
                   @keydown.enter.prevent="select(options.length?options[optionSelected]:{descricao:searchFor})"
                   v-model="searchFor"
                   ref="search"
                   placeholder="Digite o nome para pesquisar">
        </div>
        <div class="select2-search" v-if="opened">
            <button type="button" class="button" disabled v-if="searching">Buscando "{{searchFor}}"...</button>
            <button type="button" class="button is-white option" v-if="noMatches"
                    @blur="close"
                    :class="{'is-info':optionSelected===0}"
                    @click="select({descricao: searchFor})">Add "{{ searchFor }}"</button>
            <button type="button" class="button is-white option" v-for="(secao, index) in options"
                    :class="{'is-info':index===optionSelected}"
                    @blur="close"
                    @click="select(secao)" v-text="secao.descricao"></button>
            <span class="help is-info" v-if="meta.total > 10 && opened">
                Exibindo {{ meta.from }} a {{ meta.to }} de um total de {{ meta.total }} resultados
            </span>
        </div>
    </div>
</template>
<script>
    import typeAheadPointer from '../mixins/typeAheadPointer';

    export default {
        mixins: [typeAheadPointer],
        name: 'select-secoes',
        props: ['secao'],
        data(){
            return {
                selected: null,
                options: [],
                meta: {},
                opened: false,
                searchFor:'',
                searching: false
            }
        },
        watch: {
            searchFor(){
                this.open();
            },
            opened(val){
                if (!val){
                    this.searchFor = '';
                }
            },
            secao() {
                this.selected = this.secao;
            }
        },
        methods: {
            open() {
                if (this.searchFor.length > 1) {
                    this.opened = true;
                }
            },
            unselect(){
                this.selected = null;
                this.$emit('selected', null);
            },
            select(secao){
                if (this.optionSelected === -1 && this.options.length === 1) {
                    secao = this.options[0];
                }

                if (typeof secao === 'undefined'){
                    flash('Selecione uma seção','erro');
                    return;
                }

                if (!secao.descricao.trim().length){
                    return;
                }

                this.selected = secao;
                this.$emit('selected', secao);

                this.typeAheadEscape();

                document.getElementById('ano').focus();
            },
            close(e){
                if (e.relatedTarget){
                    let classes = e.relatedTarget.getAttribute('class');
                    this.opened = !!classes.match(/option/);
                }
            },
            search(page=1, e){
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp' || e.key === 'Escape'){
                    return;
                }
                if (this.searching || this.searchFor.length < 2){
                    return;
                }
                this.searching = true;
                axios.get(`/api/secoes?q=${this.searchFor}&page=${page}`).then(({data}) => {
                    this.searching = false;
                    this.options = data.secoes;
                    this.meta = data.meta;
                }).catch(() => {
                    this.searching = false;
                    flash('Erro ao buscar secoes','danger')
                });
            }
        },
        created(){
            this.selected = this.secao;
        }
    }
</script>

<style lang="sass" scoped>
    .input-addon
        margin : 0 0 0.5em

    .select2-search
        border : 1px solid #d4d4d4
        background : #fff
        width : 100%
        position : absolute
        left : 0
        border-top : none
        display : flex
        flex-direction : column
        align-items : baseline
        z-index : 5
        .button
            width: 100%
            justify-content: left
        .help
            padding-left: 1em
    .tag, .tag .fa
            margin-right : 0.5em
    .is-danger .input
        border-color : #ff3860
</style>