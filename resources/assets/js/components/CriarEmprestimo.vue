<template>
    <div>
        <div class="columns">

            <div class="column">
                <!-- Input Estudante_id -->
                <div class="field">
                    <label for="estudante_id" class="label is-large">Estudante</label>
                    <span class="tag is-large" v-if="estudante">
                        {{ estudante.nome }}
                        <button class="delete is-small" @click="removeEstudante()"></button>
                    </span>
                    <div class="control has-icons-right has-icons-left" :class="{ 'is-loading': loading.has('estudante') }" v-else>
                        <input class="input" @keyup.enter="searchEstudante()" v-model="estudanteSearch" autocomplete="off"
                               ref="estudante"
                               :class="{ 'is-danger': errors.has('estudante_id') }" @keydown="errors.remove('estudante_id')"
                               id="estudante_id" placeholder="Informe a matricula ou parte do nome e pressione enter">
                        <span class="icon is-small is-left"><i class="fa fa-user"></i></span>
                        <span class="icon is-small is-right" v-if="errors.has('estudante_id')"><i class="fa fa-warning"></i></span>
                    </div>
                    <p class="help is-danger" v-if="errors.has('estudante_id')" v-text="errors.first('estudante_id')"></p>
                </div>
                <!-- Input Livros -->
                <div class="field">
                    <label for="livros" class="label is-large">
                        Livros <span v-if="livros.length" class="subtitle is-6">({{ livros.length }})</span>
                    </label>
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
                                    <h4 class="title is-5 has-text-danger">ISBN "{{ isbnNotFound }}" não encontrado</h4>
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
                                    <span class="subtitile is-7">{ Autores aqui }</span>
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
            <div class="column is-4">
                <!-- Input Devolucao -->
                <div class="field">
                    <h2 class="label">Devolução</h2>
                    <emprestimo-datepicker placeholder="Devolução" v-model="devolucao"></emprestimo-datepicker>
                </div>
            </div>
        </div>

        <!-- Form Submit -->
        <div class="has-text-centered" v-if="errors.has('form')">
            <p class="help is-danger" v-text="errors.first('form')"></p>
        </div>
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <button class="button is-info" :class="{'is-loading':loading.any()}" @click="enviar" :disabled="errors.any()">Gravar</button>
            </div>
            <div class="control">
                <button class="button" type="button">Reset</button>
            </div>
        </div>

        <div class="modal is-active" v-if="modalEnable">
            <div class="modal-content">
                <article class="message" style="border: 1px solid #faf2cc">
                    <div class="message-header">
                        <p>Busca Estudante contendo "{{estudanteSearch}}"</p>
                        <button class="delete" aria-label="delete" @click="modalEnable = false"></button>
                    </div>
                    <div class="message-body">
                        <div class="field row">
                            <div class="control has-icons-right">
                                <input class="input" autocomplete="off" v-model="estudanteSearch" @keyup="searchEstudante()" ref="modalInput">
                                <span class="icon is-small is-right"><i class="fa fa-search"></i></span>
                            </div>
                            <p class="help is-info">
                                Exibindo
                                {{
                                estudantesList.meta.per_page < estudantesList.meta.total ?
                                    estudantesList.meta.per_page :
                                    estudantesList.meta.total
                                }}
                                de um total de {{estudantesList.meta.total}}
                            </p>
                        </div>
                        <ul>
                            <li v-for="item in estudantesList.estudantes">
                                <a class="button is-link" @click="selectEstudante(item)">{{item.matricula}} - {{item.nome}}</a>
                            </li>
                        </ul>
                    </div>
                </article>
            </div>
        </div>
    </div>
</template>

<script>
    import EmprestimoDatepicker from "../components/EmprestimoDatepicker.vue"
    import Errors from '../directives/errors'
    import LoadingState from '../directives/loading'
    import moment from 'moment'

    export default {
        components: {
            "emprestimo-datepicker": EmprestimoDatepicker
        },
        mounted() {
            this.$refs.estudante.focus();
        },
        data() {
            return {
                devolucao: moment().add(7, 'days').format('DD/MM/YYYY'),
                estudante: null,
                estudanteSearch: '',
                livroSearch: '',
                estudantesList: {meta: {}, estudantes: {}},
                livros: [],
                errors: new Errors({}),
                loading: new LoadingState(),
                isbnNotFound: false,
                modalEnable: false
            }
        },
        watch: {
            livrosLoading(flag) {
                console.log("livrosLoading mudou para " + flag);
            }
        },
        methods: {
            validation() {
                if (!this.estudante) {
                    this.errors.add('estudante_id', 'Selecione um Estudante');
                }

                if (!this.livros.length) {
                    this.errors.add('livros', 'Selecione ao menos um Livro.');
                }

                if (this.loading.any()) {
                    this.errors.add('form', 'Existem transações pendentes.');
                }

                return this.errors.any();
            },
            removeEstudante() {
                this.estudante = null;
                this.$nextTick(() => this.$refs.estudante.focus());
            },
            selectEstudante(estudante) {
                this.estudante = estudante;
                this.estudantesList = {meta: {}, estudantes: {}};
                this.estudanteSearch = '';
                this.errors.remove('estudante_id');
                this.modalEnable = false;
                this.$refs.livros.focus();
            },
            searchEstudante() {
                if (!this.estudanteSearch.length) {
                    return;
                }

                this.loading.set('estudante');

                axios.get(`/api/estudantes?q=${this.estudanteSearch}`).then(({data}) => {
                    this.loading.done('estudante');
                    if (data.meta.total === 1 && !this.modalEnable) {
                        this.selectEstudante(data.estudantes[0]);
                        return;
                    }

                    if (data.meta.total === 0) {
                        this.errors.add('estudante_id', `Nenhum Estudante emcontrado contendo "${this.estudanteSearch}".`);
                        this.$refs.estudante.focus();
                        this.modalEnable = false;
                        return;
                    }

                    this.estudantesList = data;
                    this.modalEnable = true;
                    this.$nextTick(() => this.$refs.modalInput.focus());
                });
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
                    this.livros.unshift(response.data.livro);
                });

                this.livroSearch = '';
            },
            remove(livro) {
                this.livros.splice(this.livros.indexOf(livro), 1);
            },
            enviar() {

                if (this.validation()) {
                    return;
                }

                axios.post('/api/emprestimos', {
                    livros: this.livros.map(livro => {
                        return livro.id;
                    }),
                    estudante_id: this.estudante ? this.estudante.id : null,
                    devolucao: this.devolucao
                }).then(response => {
                    this.livros = [];
                    this.estudante = null;
                    flash(response.data);
//                    console.log(response.data);
                }).catch(error => {
                    console.log(error.response.data.errors);
                    this.errors.record(error.response.data.errors);
                    flash('Erro ao tentar adicionar empréstimo', 'erro');
                });
            }
        }
    };
</script>
<style scoped>
    .card-content {
        padding: 0.3rem 0.7rem;
    }

    .level:not(:last-child) {
        margin-bottom: 0;
    }

    .title:not(:last-child) {
        margin-bottom: 0.2rem;
    }

    .has-border-bottom {
        border-bottom: 1px solid #dbdbdb;
    }

    input[type='number'] {
        -moz-appearance: textfield;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
</style>