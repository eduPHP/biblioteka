<template>
    <transition name="fade">
        <div class="modal is-active" v-if="active">
            <div class="modal-background" @click="close"></div>
            <form @submit.prevent="enviar" ref="form">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title" v-if="id">
                            <span class="icon is-small"><i class="fa fa-pencil"></i></span> Editar Seção {{ descricao }}
                        </p>
                        <p class="modal-card-title" v-else>
                            <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Seção
                        </p>
                        <button class="delete" type="button" @click="close" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">
                        <!-- Input Descição -->
                        <div class="field">
                            <label class="label" for="descricao">Descição</label>
                            <div class="control has-icons-right">
                                <input class="input" :class="{'is-danger' : errors.has('descricao')}"
                                       name="descricao" id="descricao" v-model="descricao" ref="descricao"
                                       @change="errors.remove('descricao')">
                                <span class="icon is-small is-right" v-if="errors.has('descricao')">
                                    <i class="fa fa-warning"></i>
                                </span>
                            </div>
                            <p class="help is-danger" v-if="errors.has('descricao')" v-text="errors.first('descricao')"></p>
                        </div>
                        <!-- Input Localizacao -->
                        <div class="field">
                            <label class="label" for="localizacao">Localização</label>
                            <div class="control has-icons-right">
                                <input class="input" :class="{'is-danger' : errors.has('localizacao')}"
                                       name="localizacao" id="localizacao"
                                       @change="errors.remove('localizacao')" v-model="localizacao">
                                <span class="icon is-small is-right" v-if="errors.has('localizacao')">
                                    <i class="fa fa-warning"></i>
                                </span>
                            </div>
                            <p class="help is-danger" v-if="errors.has('localizacao')" v-text="errors.first('localizacao')"></p>
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
    import formCommons from '../mixins/formCommons'

    export default {
        mixins: [formCommons],
        name: 'form-secao',
        props: ['secao'],
        data() {
            return {
                descricao: '',
                localizacao: ''
            }
        },

        methods: {
            enviar() {
                this.enviando = true;
                let data = {
                    descricao: this.descricao,
                    localizacao: this.localizacao
                };

                if (this.id) {
                    axios.patch(`/api/secoes/${this.id}`, data).then(result => {
                        this.enviando = false;
                        if (result.status === 201) {
                            flash('Seção Modificada');
                            this.close(true);
                        }
                    }).catch(error => {
                        this.enviando = false;
                        this.errors.record(error.response.data.errors)
                    });
                    return;
                }
                axios.post('/api/secoes', data).then(result => {
                    this.enviando = false;
                    this.id = result.data.secao.id;
                    if (result.status === 201) {
                        flash('Seção Adicionada');
                        this.close(true);
                    }
                }).catch(error => {
                    this.enviando = false;
                    this.errors.record(error.response.data.errors)
                });

            },
            resetForm() {
                if (!this.secao) {
                    this.$refs.form.reset();
                    this.$refs.descricao.focus();
                    return;
                }
                this.id = this.secao.id;
                this.descricao = this.secao.descricao;
                this.localizacao = this.secao.localizacao;
                this.$refs.descricao.focus();
            }
        }
    }
</script>
