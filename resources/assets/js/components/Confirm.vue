<template>
    <div class="modal" :class="{'is-active': active }">
        <div class="modal-background"></div>
        <div class="modal-card modal-confirm">
            <header class="modal-card-head">
                <p v-text="message"></p>
            </header>
            <footer class="modal-card-foot">
                <div class="flex-1"></div>
                <button class="button is-success has-icons" @click="accept">
                    <span class="icon"><i class="fa" :class="icon"></i></span> <span v-text="button"></span>
                </button>
                <button class="button" @click="close">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'confirm',
        data() {
            return {
                active: false,
                icon: 'fa-check',
                button: 'Continuar',
                message: 'Tem certeza?'
            }
        },
        methods: {
            accept() {
                window.events.$emit('accepted', _.clone(this.message));
                this.close();
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
            window.events.$on('confirm', (message, acceptText, acceptIcon) => {
                this.message = message;
                this.button = acceptText;
                this.icon = acceptIcon;
                this.open();
            })
        }
    }
</script>