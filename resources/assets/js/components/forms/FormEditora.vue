<template>
    <transition name="fade">
        <div class="modal is-active" v-if="active">
            <div class="modal-background" @click="close"></div>
            <form @submit.prevent="enviar" ref="form">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title" v-if="id">
                        <span class="icon is-small"><i class="fa fa-pencil"></i></span> Editar Editora {{ nome }}
                    </p>
                    <p class="modal-card-title" v-else>
                        <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Editora
                    </p>
                    <button class="delete" type="button" @click="close" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                        <!-- Input Nome -->
                        <div class="field">
                            <label class="label" for="nome">Nome</label>
                            <div class="control has-icons-right">
                                <input class="input" :class="{'is-danger' : errors.has('nome')}"
                                       name="nome" id="nome" v-model="nome" ref="nome"
                                       @change="errors.remove('nome')" v-focus>
                                <span class="icon is-small is-right" v-if="errors.has('nome')">
                        <i class="fa fa-warning"></i>
                    </span>
                            </div>
                            <p class="help is-danger" v-if="errors.has('nome')" v-text="errors.first('nome')"></p>
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

    export default {
        mixins: [formCommons],
        name: 'form-editora',
        props: ['editora'],
        data() {
            return {
                nome: ''
            }
        },
        methods: {
            enviar() {
                this.enviando = true;
                let data = {
                    nome: this.nome
                };

                if (this.id) {
                    axios.patch(`/api/editoras/${this.id}`, data).then(result => {
                        this.enviando = false;
                        if (result.status === 201) {
                            flash('Editora Modificada');
                            this.close(true);
                        }
                    }).catch(error => {
                        this.enviando = false;
                        this.errors.record(error.response.data.errors)
                    });
                    return;
                }
                axios.post('/api/editoras', data).then(result => {
                    this.enviando = false;
                    this.id = result.data.editora.id;
                    if (result.status === 201) {
                        flash('Editora Adicionada');
                        this.close(true);
                    }
                }).catch(error => {
                    this.enviando = false;
                    this.errors.record(error.response.data.errors)
                });

            },
            resetForm(){
                if (!this.editora) {
                    this.$refs.form.reset();
                    return;
                }
                this.id = this.editora.id;
                this.nome = this.editora.nome;
            }
        }
    }
</script>
