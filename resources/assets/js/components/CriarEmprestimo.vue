<template>
    <div>
        <div class="columns">

            <div class="column">
                <!-- Input Estudante_id -->
                <div class="field">
                    <label for="estudante_id" class="label is-large">Estudante</label>
                    <span class="tag" v-if="estudante">
                        {{ estudante.nome }}
                        <button class="delete is-small" @click="estudante = null"></button>
                    </span>
                    <div class="control has-icons-right has-icons-left" v-else>
                        <input class="input" @keyup.enter="searchEstudante" v-model="estudanteSearch" autocomplete="off"
                               :class="{ 'is-danger': errors.has('estudante_id') }" @keydown="errors.remove('estudante_id')"
                               id="estudante_id" placeholder="Informe a matricula ou parte do nome e pressione enter">
                        <span class="icon is-small is-left"><i class="fa fa-user"></i></span>
                        <span class="icon is-small is-right" v-if="errors.has('estudante_id')"><i class="fa fa-warning"></i></span>
                    </div>
                    <p class="help is-danger" v-if="errors.has('estudante_id')" v-text="errors.first('estudante_id')"></p>
                </div>
                <!-- Input Livros -->
                <div class="field">
                    <label for="livros" class="label is-large">Livros <span v-if="livros.length" class="subtitle is-6">({{ livros.length
                                                                                                                       }})</span></label>
                    <div class="control has-icons-right has-icons-left">
                        <input class="input" @keyup.enter="searchLivro" v-model="livroSearch"
                               autocomplete="off" :class="{ 'is-danger': errors.has('livros') }"
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
                                    <h4 class="title is-5 has-text-danger">ISBN {{ isbnNotFound }} não encontrado</h4>
                                </div>
                            </div>
                        </div>
                        <div class="content mt-1">
                            <button class="button is-info is-small" type="button">Adicionar</button>
                        </div>
                    </div>

                    <div class="card-content has-border-bottom" v-if="!livros.length && !isbnNotFound && !livrosLoading">
                        <div class="content">
                            <h3>Informe um ISBN para pesquisar... <i class="fa fa-arrow-up"></i></h3>
                        </div>
                    </div>

                    <div class="card-content has-border-bottom" v-for="livro in livros">
                        <div class="level">
                            <div class="level-left">
                                <div>
                                    <h4 class="title is-5">{{ livro.titulo }}</h4>
                                    <span class="subtitile is-7"> Eduardo</span>
                                </div>
                            </div>
                            <button class="delete level-right" type="button" @click="remove(livro)"></button>
                        </div>
                        <div class="content">
                            <p class="subtitle is-6"><strong>ISBN:</strong> {{ livro.isbn }}</p>
                        </div>
                    </div>

                    <div class="card-content has-border-bottom" v-if="livrosLoading">
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
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <button class="button is-info" @click="enviar">Gravar</button>
            </div>
            <div class="control">
                <button class="button" type="button">Reset</button>
            </div>
        </div>

    </div>
</template>

<script>
    import EmprestimoDatepicker from "../components/EmprestimoDatepicker.vue"
    import moment from 'moment'

    class Errors {
        constructor(errors) {
            this.errors = errors;
        }

        has(field) {
            return this.errors.hasOwnProperty(field);
        }

        any() {
            return Object.keys(this.errors).length;
        }

        first(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        add(field, message) {
            this.errors[field] = [message];
        }

        remove(field) {
            delete this.errors[field];
        }

        record(errors) {
            this.errors = errors;
        }
    }

    export default {
        components: {
            "emprestimo-datepicker": EmprestimoDatepicker
        },
        data() {
            return {
                devolucao: moment().add(7, 'days').format('DD/MM/YYYY'),
                estudante: null,
                estudanteSearch: '',
                livroSearch: '',
                estudantes: [],
                livros: [],
                errors: new Errors({}),
                estudantesLoading: false,
                livrosLoading: false,
                isbnNotFound: false,
            }
        },
        methods: {
            validation(field) {
                return this.errors[field];
            },
            searchEstudante() {
                this.estudantesLoading = true;

                axios.get(`/api/estudantes?q=${this.estudanteSearch}`).then(({data}) => {
                    this.estudantesLoading = false;
                    this.estudanteSearch = '';
                    if (data.meta.total === 1) {
                        this.estudante = data.estudantes[0];
                        return;
                    }
                    this.estudantes = data.estudantes;
                    // mostra modal
                }).catch(error => {
                    //mostra errors
                });
            },
            searchLivro() {
                this.livrosLoading = true;
                this.isbnNotFound = false;
                this.errors.remove('livros');

                axios.get(`/api/livros/${this.livroSearch}`, {
                    validateStatus: function (status) {
                        return status !== 200 || status !== 404;
                    }
                }).then(response => {
                    if (response.status === 404) {
                        return this.isbnNotFound = response.data;
                    }
                    this.livros.unshift(response.data.livro);
                });

                this.livrosLoading = false;
                this.livroSearch = '';
            },
            remove(livro) {
                this.livros.splice(this.livros.indexOf(livro), 1);
            },
            enviar() {
                axios.post('/api/emprestimos', {
                    livros: this.livros.map(livro => {
                        return livro.id;
                    }),
                    estudante_id: this.estudante ? this.estudante.id : null,
                    devolucao: this.devolucao
                }).then(response => {
                    this.livros = [];
                    this.estudante = null;
                    console.log(response);
                }).catch(error => {
                    console.log(error.response.data.errors);
                    this.errors.record(error.response.data.errors);
                });
            }
        }
    };
</script>
<style>
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
</style>