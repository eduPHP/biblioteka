<template>
    <div>
        <div class="select2-multi">
            <div class="input-addon">
                <span class="tag tag-default" v-for="autor in selected" :class="{'is-success':!autor.id}">
                    <i class="fa fa-plus" v-if="!autor.id"> </i>
                    {{ autor.nome }} <a class="delete is-small" @click="removeAutor(autor)"></a>
                </span>
            </div>
            <input class="input" @blur="close" @focus="open"
                   @keyup="search(1, $event)"
                   @keydown.down.prevent="typeAheadDown"
                   @keydown.up.prevent="typeAheadUp"
                   @keydown.esc.prevent="typeAheadEscape"
                   @keydown.enter.prevent="select(options.length?options[optionSelected]:{nome:searchFor})"
                   v-model="searchFor"
                   ref="search"
                   placeholder="Digite o nome para pesquisar">
        </div>
        <div class="select2-search" v-if="opened">
            <button type="button" class="button" disabled v-if="searching">Buscando "{{searchFor}}"...</button>
            <button type="button" class="button is-white option" v-if="noMatches"
                    @blur="close"
                    :class="{'is-info':optionSelected===0}"
                    @click="select({nome: searchFor})">Add "{{ searchFor }}"</button>
            <button type="button" class="button is-white option" v-for="(autor, index) in options"
                    :class="{'is-info':index===optionSelected}"
                    @blur="close"
                    @click="select(autor)" v-text="autor.nome"></button>
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
        name: 'select-autores',
        props: {
            autores: {
                type: Array,
                default: []
            }
        },
        data(){
            return {
                selected: this.autores,
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
            autores() {
                this.selected = this.autores;
            }
        },
        methods: {
            open() {
                if (this.searchFor.length > 1) {
                    this.opened = true;
                }
            },
            removeAutor(autor){
                let i = this.selected.findIndex(i => i.nome === autor.nome);
                this.selected.splice(i, 1);
            },
            select(autor){
                if (this.optionSelected === -1 && this.options.length === 1) {
                    autor = this.options[0];
                }

                if (typeof autor === 'undefined'){
                    flash('Selecione um autor', 'erro');
                    return;
                }

                if (!autor.nome.trim().length){
                    return;
                }

                if (this.selected.findIndex(i => i.nome === autor.nome) === -1){
                    this.selected.push(autor);
                }

                this.$emit('selected', this.selected);

                this.typeAheadEscape();

                this.$refs.search.focus();
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
                axios.get(`/api/autores?q=${this.searchFor}&page=${page}`).then(({data}) => {
                    this.searching = false;
                    this.options = data.autores;
                    this.meta = data.meta;
                }).catch(() => {
                    this.searching = false;
                    flash('Erro ao buscar autores','danger')
                });
            }
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