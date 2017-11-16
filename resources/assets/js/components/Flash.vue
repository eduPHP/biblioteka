<template>
    <div class="notification" :class="typeClass" v-if="show">
        <button class="delete" @click="show = false"></button>
        <strong>{{ title }}</strong>{{ body }}
    </div>
</template>
<script>
    export default {
        props: ['mensagem', 'tipo', 'tempo'],

        data() {
            return {
                type: 'sucesso',
                body: '',
                show: false
            }
        },
        computed: {
            typeClass() {
                return `is-${this.type}`
            },
            title() {
                return _.capitalize(this.type) + '! '
            }
        },
        methods: {
            hide(){
                setTimeout(() => {
                    this.show = false;
                }, 5000)
            },
            flash(message, type='sucesso'){
                this.body = message;
                this.type = type;
                this.show = true;
                this.hide();
            }
        },
        created() {
            if (this.tipo){
                this.type = this.tipo;
            }

            if (this.mensagem) {
                this.flash(this.mensagem, this.type)
            }

            window.events.$on('flash', (message, type='sucesso') => {
                this.flash(message,type)
            })
        }
    }
</script>

<style scoped>
    .notification {
        position  : fixed;
        z-index   : 20;
        bottom    : 2em;
        right     : 2em;
        max-width : 30em
    }

    .is-sucesso {
        background-color: #23d160;
        color: #fff;
    }

    .is-erro {
        background-color: #ff3860;
        color: #fff;
    }

    .is-alerta {
        background-color: #ffdd57;
        color: rgba(0, 0, 0, 0.7);
    }
</style>