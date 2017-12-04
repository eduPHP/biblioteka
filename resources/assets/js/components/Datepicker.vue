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
            @opened="onOpen"
            wrapper-class="control has-icons-left"
            calendar-button-icon="fa fa-calendar-o"
    ></datepicker>
</template>
<script>
    import moment from 'moment'
    import 'moment/locale/pt-br'

    import Datepicker from 'vuejs-datepicker'

    export default {
        name: 'datepick',
        props: ['inline','date','required', 'placeholder'],
        components: {Datepicker},
        data(){
            return {
                selecionada: this.date
            }
        },
        watch:{
            selecionada(){
                return this.$emit('changed', this.selecionada);
            },
            date(){
                this.selecionada = this.date;
            }
        }
    }

</script>