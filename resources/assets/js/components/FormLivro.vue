<template>
    <div>
        <div class="columns">
            <div class="column">
                <!-- Input Isbn -->
                <div class="field">
                    <label class="label" for="isbn">ISBN</label>
                    <div class="control has-icons-right">
                        <input class="input" :class="{'is-danger' : errors.has('isbn')}"
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
                               name="quantidade" id="quantidade" v-model="quantidade">
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
                    <label class="label is-marginless">Autores <span class="subtitle is-7">(0)</span></label>
                    <div class="control" :class="{'has-icons-right is-danger':errors.has('autores')}">
                        <select-autores data="autores"></select-autores>
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
                       name="titulo" id="titulo" v-model="titulo">
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
                          v-model="descricao" rows="3"></textarea>
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
                        <select-editoras></select-editoras>
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
                        <select-secoes></select-secoes>
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
                               type="number" name="ano" id="ano" v-model="ano">
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
                               name="edicao" id="edicao" v-model="edicao">
                        <span class="icon is-small is-right" v-if="errors.has('edicao')">
                            <i class="fa fa-warning"></i>
                        </span>
                    </div>
                    <p class="help is-danger" v-if="errors.has('edicao')" v-text="errors.first('edicao')"></p>
                </div>

            </div>
        </div>

        <!-- Form Submit -->
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-info" :class="{'is-success': id}">Gravar</button>
            </div>
            <div class="control">
                <button type="reset" class="button">Reset</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Errors from '../directives/errors'
    import SelectAutores from '../components/SelectAutores.vue';
    import SelectEditoras from '../components/SelectEditoras.vue';
    import SelectSecoes from '../components/SelectSecoes.vue';

    export default {
        components: {
            'select-autores': SelectAutores,
            'select-editoras': SelectEditoras,
            'select-secoes': SelectSecoes
        },
        props: ['livro'],
        data() {
            return {
                id: null,
                isbn: '',
                quantidade: 1,
                autores: [],
                titulo: '',
                descricao: '',
                editora_id: null,
                secao_id: null,
                ano: '',
                edicao: '',
                errors: new Errors({})
            }
        },
        mounted(){
            this.isbn = 123;
        }
    }
</script>

<style>

</style>