<template>
    <div class="modal is-active" v-if="active">
        <div class="modal-background"></div>
        <div class="modal-card modal-confirm">
            <header class="modal-card-head">
                <p v-text="message"></p>
            </header>
            <footer class="modal-card-foot">
                <div class="flex-1"></div>
                <button class="button is-success has-icons" @click="accept" v-focus>
                    <span class="icon"><i class="fa" :class="icon"></i></span> <span v-text="button"></span>
                </button>
                <button class="button" @click="close">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
    import focus from '../directives/focus'

    export default {
        directives: {focus},
        name: 'confirm',
        data() {
            return {
                active: false,
                icon: 'fa-check',
                button: 'Continuar',
                message: 'Tem certeza?',
                callback: null
            }
        },
        methods: {
            accept() {
                if (this.callback){
                    this.callback();
                    this.close();
                    return;
                }
                flash('Confirmado :)');
            },
            open(){
                this.active = true;
            },
            close() {
                this.active = false;
                this.message = '';
            }
        },
        created(){
            window.events.$on('confirm', (callback, message, acceptText, acceptIcon) => {
                this.message = message;
                this.button = acceptText;
                this.icon = acceptIcon;
                this.callback = callback;
                this.open();
            })
        }
    }
</script>

<style>
    .modal-confirm {
        width : 400px;
    }
</style>