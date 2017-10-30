export default {
    data(){
        return {
            optionSelected: -1
        };
    },
    computed: {
        noMatches() {
            return this.searchFor.length > 2 && !this.options.length;
        }
    },
    watch: {
        options() {
            this.optionSelected = -1
        }
    },
    methods: {
        typeAheadEscape() {
            this.options = [];
            this.opened = false;
            this.searchFor = '';
            this.optionSelected = -1;
        },
        typeAheadDown() {
            if (this.optionSelected === this.options.length - 1) {
                this.optionSelected = -1;
            }

            this.optionSelected++;

            if (this.noMatches){
                this.optionSelected = 0;
            }
        },
        typeAheadUp() {
            if (this.optionSelected === 0) {
                this.optionSelected = this.options.length - 1;
                return;
            }

            if (this.noMatches) {
                this.optionSelected = 0;
                return;
            }

            this.optionSelected--;

        },

    }
};