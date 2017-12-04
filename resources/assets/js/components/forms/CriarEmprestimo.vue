<template>
    <transition name="fade">
        <div class="modal is-active" v-if="active">
            <div class="modal-background" @click="close"></div>
                <div class="modal-card" :class="{'expanded':expanded}">
                    <header class="modal-card-head">
                        <p class="modal-card-title">
                            <span class="icon is-small"><i class="fa fa-plus"></i></span> Empréstimo de Livros
                        </p>
                        <a @click="expand" aria-label="expand"><i class="fa fa-window-maximize" :class="{'fa-window-minimize':expanded}"></i></a>
                        <button class="delete" type="button" @click="close" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body" ref="modalBody">
                        <div class="columns is-block-tablet">

                            <div class="column is-12-tablet">
                                <!-- Input Estudante_id -->
                                <div class="field">
                                    <label class="label is-large">Estudante</label>
                                    <span class="tag is-large" v-if="estudante">
                                        {{ estudante.nome }}
                                        <button type="button" class="delete is-small" @click="removeEstudante()"></button>
                                    </span>
                                    <div class="control has-icons-right has-icons-left" :class="{ 'is-danger': errors.has('estudante_id') }" v-else>
                                        <select-estudante
                                                @selected="selectEstudante($event)"
                                                @error="errors.add('estudante_id', $event)"
                                                @searching="errors.remove('estudante_id')"
                                                :estudante="estudante"></select-estudante>
                                        <span class="icon is-small is-right" v-if="errors.has('estudante_id')"><i class="fa fa-warning"></i></span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('estudante_id')" v-text="errors.first('estudante_id')"></p>
                                </div>
                                <!-- Input Livros -->
                                <div class="field">
                                    <label for="livros" class="label is-large">
                                        Livros <span v-if="livros.length" class="subtitle is-6">({{ livros.length
                                                                                                }})</span> </label>
                                    <div class="control has-icons-right has-icons-left" :class="{'is-loading': loading.has('livros')}">
                                        <input class="input" @keyup.enter="searchLivro" v-model="livroSearch" ref="livros"
                                               autocomplete="off" :class="{ 'is-danger': errors.has('livros') }" type="number"
                                               id="livros" placeholder="Informe o ISBN e pressione enter">
                                        <span class="icon is-small is-left"><i class="fa fa-barcode"></i></span>
                                        <span class="icon is-small is-right" v-if="errors.has('livros')"><i class="fa fa-warning"></i></span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('livros')" v-text="errors.first('livros')"></p>
                                </div>

                                <div class="card">
                                    <div class="card-content has-border-bottom" v-if="isbnNotFound">
                                        <div class="level">
                                            <div class="level-left">
                                                <div>
                                                    <h4 class="title is-5 has-text-danger">
                                                        ISBN "{{ isbnNotFound }}" não encontrado
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content mt-1">
                                            <button class="button is-info is-small" type="button">Adicionar</button>
                                        </div>
                                    </div>

                                    <div class="card-content has-border-bottom" v-if="!livros.length && !isbnNotFound && !loading.has('livros')">
                                        <div class="content">
                                            <h3>Informe um ISBN para pesquisar... <i class="fa fa-arrow-up"></i></h3>
                                        </div>
                                    </div>

                                    <div class="card-content has-border-bottom" v-for="livro in livros">
                                        <div class="level">
                                            <div class="level-left">
                                                <div>
                                                    <h4 class="title is-5">{{ livro.titulo }}</h4>
                                                    <span class="subtitile is-7 autores"><span v-for="autor in livro.autores" v-text="autor.nome"></span></span>
                                                </div>
                                            </div>
                                            <button class="delete level-right" type="button" @click="remove(livro)"></button>
                                        </div>
                                        <div class="content">
                                            <p class="subtitle is-6"><strong>ISBN:</strong> {{ livro.isbn }}</p>
                                        </div>
                                    </div>

                                    <div class="card-content has-border-bottom" v-if="loading.has('livros')">
                                        <div class="level">
                                            <div class="level-left">
                                                <div>
                                                    <h4 class="title is-5">Buscando...</h4>
                                                </div>
                                            </div>
                                            <button class="delete level-right" type="button"></button>
                                        </div>
                                        <div class="content mt-1">
                                            <p class="subtitle is-6"><strong>ISBN:</strong> {{ livroSearch }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="column is-4 is-12-tablet">
                                <!-- Input Devolucao -->
                                <div class="field">
                                    <h2 class="label">Devolução</h2>
                                    <emprestimo-datepicker
                                            placeholder="Devolução"
                                            :date.sync="devolucao"
                                            @change="devolucao = $event"
                                    ></emprestimo-datepicker>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <div class="field is-grouped">
                            <!-- Form Submit -->
                            <div class="control">
                                <button class="button is-info"
                                        @click="enviar"
                                        :class="buttonClass"
                                        :disabled="enviando">Gravar
                                </button>
                            </div>
                            <div class="control">
                                <button @click="reset" type="button" class="button">Reset</button>
                            </div>
                        </div>
                    </footer>
                </div>
        </div>
    </transition>
</template>

<script>
    import EmprestimoDatepicker from "../EmprestimoDatepicker.vue"
    import SelectEstudante from "../SelectEstudante.vue"
    import LoadingState from '../../directives/loading'
    import formCommons from '../../mixins/formCommons'
    import moment from 'moment'

    export default {
        mixins: [formCommons],
        name: 'criar-emprestimo',
        components: {
            EmprestimoDatepicker,
            "emprestimo-datepicker": EmprestimoDatepicker,
            "select-estudante": SelectEstudante
        },
        data() {
            return {
                devolucao: moment().add(7, 'days').toDate(),
                estudante: null,
                livroSearch: '',
                livros: [],
                loading: new LoadingState(),
                isbnNotFound: false,
                expanded: false
            }
        },

        methods: {

            expand(){
                this.expanded = !this.expanded;
            },

            selectEstudante(estudante) {
                this.estudante = estudante;
                this.$refs.livros.focus();
            },

            removeEstudante(){
                this.selectEstudante(null);
            },

            searchLivro() {

                if (!this.livroSearch.length) {
                    return;
                }

                this.loading.set('livros');
                this.isbnNotFound = false;
                this.errors.remove('livros');

                axios.get(`/api/livros/${this.livroSearch}`, {
                    validateStatus: function (status) {
                        return status !== 200 || status !== 404;
                    }
                }).then(response => {
                    this.loading.done('livros');
                    if (response.status === 404) {
                        return this.isbnNotFound = response.data;
                    }
                    if (response.data.livros.disponiveis <= 0){
                        flash("Livro Indisponível", "alerta");
                        return;
                    }
                    this.livros.unshift(response.data.livros);
                });

                this.livroSearch = '';
            },
            remove(livro) {
                this.livros.splice(this.livros.indexOf(livro), 1);
            },
            resetForm() {
                this.livros = [];
                this.estudante = null;
                this.livroSearch = '';
                this.isbnNotFound = false;
            },
            enviar() {
                axios.post('/api/emprestimos', {
                    livros: this.livros.map(livro => {
                        return livro.id;
                    }),
                    estudante_id: this.estudante ? this.estudante.id : null,
                    devolucao: this.devolucao
                }).then(response => {
                    flash(response.data);
                    this.close(true);
                }).catch(error => {
                    this.errors.record(error.response.data.errors);
                    flash('Erro ao tentar adicionar empréstimo', 'erro');
                });
            }
        },
        created(){
            events.$on('estudante-created', (estudante) => {
                console.log(estudante);
                this.selected = estudante;
            });
        }
    };
</script>
<style scoped>
    .card-content {
        padding : 0.3rem 0.7rem;
    }

    .level:not(:last-child) {
        margin-bottom : 0;
    }

    .title:not(:last-child) {
        margin-bottom : 0.2rem;
    }

    .has-border-bottom {
        border-bottom : 1px solid #dbdbdb;
    }

    input[type='number'] {
        -moz-appearance : textfield;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance : none;
    }

    .autores span + span:before {
        content : ', ';
    }

    .modal-card.expanded{
        min-width  : 100%;
        min-height : 100%;
        margin: 0;
    }
    .fa-window-maximize, .fa-window-minimize {
        margin-right: 1rem;
    }
</style>