<template>
    <transition name="fade">
        <div class="modal is-active" v-if="active">
            <div class="modal-background" @click="close"></div>
            <form @submit.prevent="enviar" ref="form">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title" v-if="id">
                        <span class="icon is-small"><i class="fa fa-pencil"></i></span> Editar Estudante {{ nome }}
                    </p>
                    <p class="modal-card-title" v-else>
                        <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Estudante
                    </p>
                    <button class="delete" type="button" @click="close" aria-label="close"></button>
                </header>
                <section class="modal-card-body">

                    <!-- Input Matricula -->
                    <div class="field">
                        <label class="label" for="matricula">Matrícula</label>
                        <div class="control has-icons-right">
                            <input class="input" :class="{'is-danger' : errors.has('matricula')}"
                                   name="matricula" id="matricula"
                                   v-model="matricula" ref="matricula"
                                   @change="errors.remove('matricula')">
                            <span class="icon is-small is-right" v-if="errors.has('matricula')">
                                    <i class="fa fa-warning"></i>
                                </span>
                        </div>
                        <p class="help is-danger" v-if="errors.has('matricula')" v-text="errors.first('matricula')"></p>
                    </div>
                    <!-- Input Nome -->
                    <div class="field">
                        <label class="label" for="nome">Nome</label>
                        <div class="control has-icons-right">
                            <input class="input" :class="{'is-danger' : errors.has('nome')}"
                                   name="nome" id="nome" v-model="nome"
                                   @change="errors.remove('nome')">
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
    import formCommons from '../mixins/formCommons'

    export default {
        mixins: [formCommons],
        name: 'form-estudante',
        props: ['estudante'],
        data() {
            return {
                matricula: '',
                nome: ''
            }
        },
        methods: {
            enviar() {
                this.enviando = true;
                let data = {
                    matricula: this.matricula,
                    nome: this.nome
                };

                if (this.id) {
                    axios.patch(`/api/estudantes/${this.id}`, data).then(result => {
                        this.enviando = false;
                        if (result.status === 201) {
                            flash('Estudante Modificado');
                            this.close();
                        }
                    }).catch(error => {
                        this.enviando = false;
                        this.errors.record(error.response.data.errors)
                    });
                    return;
                }
                axios.post('/api/estudantes', data).then(result => {
                    this.enviando = false;
                    this.id = result.data.estudante.id;
                    if (result.status === 201) {
                        flash('Estudante Adicionado')
                        this.close();
                    }
                }).catch(error => {
                    this.enviando = false;
                    this.errors.record(error.response.data.errors)
                });

            },
            resetForm(){
                this.$refs.matricula.focus();
                if (!this.estudante) {
                    this.$refs.form.reset();
                    return;
                }
                this.id = this.estudante.id;
                this.matricula = this.estudante.matricula;
                this.nome = this.estudante.nome;
            }
        }
    }
</script>
