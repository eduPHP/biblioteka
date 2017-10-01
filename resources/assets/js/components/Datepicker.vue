<template>
    <div class="datepicker">
        <div class="field">

            <div class="control has-icon has-icon-right">
                <input class="input" value="10/10/2010" :name="name" :placeholder="placeholder" type="text" v-model="interVal" ref="picker">
                <span class="icon is-small is-right"><i class="fa fa-calendar"></i></span>
            </div>
        </div>

    </div>
</template>
<script>
    import Flatpickr from 'flatpickr';
    import Portugues from "flatpickr/src/l10n/pt";

    let moment = require('moment');
    import 'moment/locale/pt-br';

    export default {
        props: {
            name: String,
            placeholder: String,
            value: String
        },

        data() {
            let plusSeven = moment().add(8, 'days');
            return {
                interVal: this.value,
                flatPickr: null,
                options: {
                    locale: Portugues.pt,
                    inline: true,
                    dateFormat: 'd/m/Y',
                    minDate: 'today',
                    disable: [
                        function (date) {
                            return date.getDay() === 0;
                        }
                    ],
                }
            };
        },

        methods: {
            changeVal() {
                this.$emit('input', this.interVal);
            },
            handleClear() {
                this.flatPickr && this.flatPickr.clear();
            },
        },

        watch: {
            interVal() {
                this.defaultDate = this.interVal;
//                this.flatPickr.setDate(new Date(2015, 0, 10), '', this.options.dateFormat);
//                console.log(this.interVal);
//                this.flatPickr.redraw();
                this.$emit('input', this.interVal);
            },
        },

        mounted() {
            const pickerEl = this.$refs.picker;
            this.flatPickr = new Flatpickr(pickerEl, this.options);
        },

        beforeDestroy() {
            if (this.flatPickr) {
                this.flatPickr.destroy();
                this.flatPickr = null;
            }
        },
    };
</script>
