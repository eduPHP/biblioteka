<template>
    <datepicker
            :inline="inline"
            :calendar-button="true"
            :bootstrap-styling="false"
            input-class="input"
            :placeholder="placeholder"
            v-model="selecionada"
            format="dd/MM/yyyy"
            language="pt-br"
            :disabled="disabled"
            :highlighted="highlighted"
            wrapper-class="control has-icons-left"
            calendar-button-icon="fa fa-calendar-o"
            ref="datepick"
    ></datepicker>
</template>
<script>
    import moment from 'moment'
    import 'moment/locale/pt-br'
    import Datepicker from 'vuejs-datepicker'

    export default {
        name: 'emprestimo-datepicker',
        props: ['date', 'required', 'placeholder'],
        components: {Datepicker},
        data() {
            return {
                selecionada: this.date,
                inline: false,
                disabled: {
                    "to": moment().subtract(1, 'days').toDate(),
                    "from": moment().add(14, 'days').toDate(),
                    customPredictor(date) {
                        if (date.getDay() === 0) {
                            return true
                        }
                    }
                }
            }
        },

        computed: {
            highlighted(){
                return {
                    "from": moment().startOf('day').toDate(),
                    "to": moment(this.selecionada).toDate(),
                }
            }
        },

        watch: {
            selecionada() {
                return this.$emit('changed', this.selecionada);
            },
            date() {
                this.selecionada = this.date;
            }
        },
        methods: {
            onOpen(){
                this.$emit('opened');
            }
        }
    }

</script>

<style>
    .vdp-datepicker__calendar-button {
        color           : #dbdbdb;
        height          : 2.25em;
        pointer-events  : none;
        position        : absolute;
        top             : 0;
        width           : 2.25em;
        z-index         : 4;
        align-items     : center;
        display         : inline-flex;
        justify-content : center;
    }
</style>