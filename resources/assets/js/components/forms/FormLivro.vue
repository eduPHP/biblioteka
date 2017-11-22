<template>
    <transition name="fade">
        <div class="modal is-active" v-if="active">
            <div class="modal-background" @click="close"></div>
            <form @submit.prevent="enviar" ref="form">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title" v-if="id">
                            <span class="icon is-small"><i class="fa fa-pencil"></i></span> Editar Livro {{ titulo }}
                        </p>
                        <p class="modal-card-title" v-else>
                            <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Livro
                        </p>
                        <button class="delete" type="button" @click="close" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns">
                            <div class="column">
                                <!-- Input Isbn -->
                                <div class="field">
                                    <label class="label" for="isbn">ISBN</label>
                                    <div class="control has-icons-right">
                                        <input class="input" :class="{'is-danger' : errors.has('isbn')}"
                                               @keydown.enter.prevent="search" @blur="search"
                                               @change="errors.remove('isbn')" ref="isbn" v-focus
                                               name="isbn" id="isbn" v-model="isbn"> <span class="icon is-small is-right">
                                            <i class="fa fa-barcode" :class="{'fa-warning' : errors.has('isbn')}"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('isbn')" v-text="errors.first('isbn')"></p>
                                </div>
                            </div>
                            <div class="column">
                                <!-- Input Quantidade -->
                                <div class="field">
                                    <label class="label" for="quantidade">Quantidade</label>
                                    <div class="control has-icons-right">
                                        <input type="number" class="input" :class="{'is-danger' : errors.has('quantidade')}"
                                               name="quantidade" id="quantidade" v-model="quantidade"
                                               @change="errors.remove('quantidade')">
                                        <span class="icon is-small is-right" v-if="errors.has('quantidade')">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('quantidade')" v-text="errors.first('quantidade')"></p>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half-tablet">
                                <!-- Select Autores -->
                                <div class="field">
                                    <label class="label is-marginless">Autores <span class="subtitle is-7">({{ autores.length }})</span></label>
                                    <div class="control" :class="{'has-icons-right is-danger':errors.has('autores')}">
                                        <select-autores
                                                @selected="selectAutor($event)"
                                                :autores="autores"></select-autores>
                                        <span class="icon is-small is-right" v-if="errors.has('autores')">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('autores')" v-text="errors.first('autores')"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Input Titulo -->
                        <div class="field">
                            <label class="label" for="titulo">Titulo</label>
                            <div class="control has-icons-right">
                                <input class="input" :class="{'is-danger' : errors.has('titulo')}"
                                       name="titulo" id="titulo" v-model="titulo"
                                       @change="errors.remove('titulo')">
                                <span class="icon is-small is-right" v-if="errors.has('titulo')">
                                    <i class="fa fa-warning"></i>
                                </span>
                            </div>
                            <p class="help is-danger" v-if="errors.has('titulo')" v-text="errors.first('titulo')"></p>
                        </div>

                        <!-- Textarea Descricao -->
                        <div class="field">
                            <label class="label" for="descricao">Descricao</label>
                            <div class="control has-icons-right">
                                <textarea class="textarea" name="descricao" id="descricao"
                                          :class="{'is-danger' : errors.has('descricao')}"
                                          v-model="descricao" rows="3"
                                          @change="errors.remove('descricao')"></textarea>
                                <span class="icon is-small is-right" v-if="errors.has('descricao')">
                                    <i class="fa fa-warning"></i>
                                </span>
                            </div>
                            <p class="help is-danger" v-if="errors.has('descricao')" v-text="errors.first('descricao')"></p>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <!-- Select Editora -->
                                <div class="field">
                                    <label class="label">Editora</label>
                                    <div class="control has-icons-right" :class="{'has-icons-right is-danger':errors.has('editora_id')}">
                                        <select-editoras @selected="selectEditora($event)" :editora="editora"></select-editoras>
                                        <span class="icon is-small is-right" v-if="errors.has('editora_id')">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('editora_id')" v-text="errors.first('editora_id')"></p>
                                </div>
                            </div>
                            <div class="column">
                                <!-- Select Secao -->
                                <div class="field">
                                    <label class="label">Seção</label>
                                    <div class="control has-icons-right" :class="{'has-icons-right is-danger':errors.has('secao_id')}">
                                        <select-secoes @selected="selectSecao($event)" :secao="secao"></select-secoes>
                                        <span class="icon is-small is-right" v-if="errors.has('secao_id')">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('secao_id')" v-text="errors.first('secao_id')"></p>
                                </div>

                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <!-- Input Ano -->
                                <div class="field">
                                    <label class="label" for="ano">Ano</label>
                                    <div class="control has-icons-right">
                                        <input class="input" :class="{'is-danger' : errors.has('ano')}"
                                               type="number" name="ano" id="ano" v-model="ano"
                                               @change="errors.remove('ano')" min="1000">
                                        <span class="icon is-small is-right" v-if="errors.has('ano')">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('ano')" v-text="errors.first('ano')"></p>
                                </div>

                            </div>
                            <div class="column">
                                <!-- Input Edicao -->
                                <div class="field">
                                    <label class="label" for="edicao">Edição</label>
                                    <div class="control has-icons-right">
                                        <input class="input" :class="{'is-danger' : errors.has('edicao')}"
                                               name="edicao" id="edicao" v-model="edicao"
                                               @change="errors.remove('edicao')">
                                        <span class="icon is-small is-right" v-if="errors.has('edicao')">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="errors.has('edicao')" v-text="errors.first('edicao')"></p>
                                </div>

                            </div>
                        </div>

                    </section>
                    <footer class="modal-card-foot">
                        <div class="field is-grouped">
                            <!-- Form Submit -->
                            <div class="control">
                                <button class="button is-info"
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
            </form>
        </div>
    </transition>
</template>

<script>
    import formCommons from '../../mixins/formCommons'
    import SelectAutores from '../SelectAutores.vue';
    import SelectEditoras from '../SelectEditoras.vue';
    import SelectSecoes from '../SelectSecoes.vue';

    export default {
        mixins: [formCommons],
        components: {
            'select-autores': SelectAutores,
            'select-editoras': SelectEditoras,
            'select-secoes': SelectSecoes
        },
        props: ['livro'],
        data() {
            return {
                isbn: '',
                quantidade: 1,
                autores: [],
                titulo: '',
                descricao: '',
                editora: null,
                secao: null,
                ano: '',
                edicao: ''
            }
        },
        computed:{
            isbnHasNotChanged(){
                return this.isbn.length < 2 || (this.livro && this.isbn === this.livro.isbn);
            }
        },
        methods: {
            search() {
                if (this.isbnHasNotChanged) {
                    return;
                }

                axios.get(`/api/livros/busca-isbn/${this.isbn}`).then(({data})=>{
                    this.fillEmpty(data);
                });
            },
            fillEmpty(data){
                if (!data){
                    flash('ISBN não encontrado','info');
                    return;
                }
                if (!this.titulo.length && data.titulo){
                    this.titulo = data.titulo;
                }
                if (!this.descricao.length && data.descricao){
                    this.descricao = data.descricao;
                }
                if (!this.autores.length && data.autores.length){
                    this.autores = data.autores;
                }

                if (!this.editora && data.editora){
                    this.editora = data.editora;
                }

            },
            selectAutor(autores) {
                this.autores = autores;
                this.errors.remove('autores')
            },
            selectEditora(editora) {
                this.editora = editora;
                this.errors.remove('editora_id');
            },
            selectSecao(secao) {
                this.secao = secao;
                this.errors.remove('secao_id');
            },
            enviar() {
                this.enviando = true;
                let data = {
                    isbn: this.isbn,
                    quantidade: this.quantidade,
                    autores: this.autores.map(a => {
                        return a.id ? a.id : a.nome;
                    }),
                    titulo: this.titulo,
                    descricao: this.descricao,
                    editora_id: this.editora ? this.editora.id ? this.editora.id : this.editora.nome : null,
                    secao_id: this.secao ? this.secao.id ? this.secao.id : this.secao.descricao : null,
                    ano: this.ano,
                    edicao: this.edicao
                };

                if (this.id) {
                    axios.patch(`/api/livros/${this.id}`, data).then(result => {
                        this.enviando = false;
                        if (result.status === 201) {
                            flash('Livro Modificado');
                            this.close(true);
                        }
                    }).catch(error => {
                        this.enviando = false;
                        this.errors.record(error.response.data.errors)
                    });
                    return;
                }
                axios.post('/api/livros', data).then(result => {
                    this.enviando = false;
                    this.id = result.data.livro.id;
                    if (result.status === 201) {
                        flash('Livro Adicionado');
                        this.close(true);
                    }
                }).catch(error => {
                    this.enviando = false;
                    this.errors.record(error.response.data.errors)
                });

            },
            resetForm(){
                if (!this.livro) {
                    this.$refs.form.reset();
                    this.autores = [];
                    this.editora = null;
                    this.secao = null;
                    this.titulo = '';
                    this.isbn = '';
                    this.quantidade = 1;
                    this.descricao = '';
                    this.ano = '';
                    this.edicao = '';
                    return;
                }
                this.id = this.livro.id;
                this.titulo = this.livro.titulo;
                this.isbn = this.livro.isbn;
                this.quantidade = this.livro.quantidade;
                this.descricao = this.livro.descricao;
                this.autores = _.clone(this.livro.autores);
                this.editora = _.clone(this.livro.editora);
                this.secao = _.clone(this.livro.secao);
                this.ano = this.livro.ano;
                this.edicao = this.livro.edicao;
            }
        }
    }
</script>
<style scoped>
    .modal-card {
        min-width : 45rem;
    }
</style>