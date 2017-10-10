<template>
    <div class="datepicker">
        <div class="field">
            <div class="control has-icons-left">
                <input class="input"
                       :options="options"
                       :name="name"
                       :value="interVal"
                       :placeholder="placeholder"
                       type="hidden"
                       v-model="interVal"
                       ref="pickrInput">
                <span class="icon is-small is-left"><i class="fa fa-calendar"></i></span>
            </div>

        </div>
    </div>
</template>
<script>
    import Flatpickr from 'flatpickr';
    import Portugues from "flatpickr/dist/l10n/pt";
    import moment from 'moment';
    import 'moment/locale/pt-br';

    export default {
        props: {
            name: String,
            placeholder: String,
            val: String,
            value: String
        },

        data() {
            return {
                interVal: this.value,
                flatPickr: null,
                options: {
                    dateFormat: 'd/m/Y',
                    inline: true,
                    defaultDate: this.getDefaultValue(),
                    minDate: 'today',
                    maxDate: moment().add(14, 'days').format('DD/MM/YYYY'),
                    locale: Portugues.pt,
                    disable: [
                        function (date) {
                            return date.getDay() === 0;
                        }
                    ],
                },
            };
        },

        methods: {
            getDefaultValue(){
                let value = this.value ? moment(this.value, "DD/MM/YYYY"):moment().add(7,'days');
                if(value.day() === 0){
                    value = value.day(1);
                }
                return value.format("DD/MM/YYYY");
            },
            changeVal() {
                this.$emit('input', this.interVal);
            },
            handleClear() {
                this.flatPickr && this.flatPickr.clear();
            },
        },

        watch: {
            interVal(val) {
                this.interVal = val;
                this.$emit('input', this.interVal);
            },
        },

        mounted() {
            const pickrEl = this.$refs.pickrInput;
            this.flatPickr = new Flatpickr(pickrEl, this.options);
        },

        beforeDestroy() {
            if (this.flatPickr) {
                this.flatPickr.destroy();
                this.flatPickr = null;
            }
        },
    };
</script>
