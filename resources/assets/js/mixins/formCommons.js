import Errors from '../directives/errors';
import focus from '../directives/focus';

export default {
    directives: {focus: focus},
    replace: true,
    props: ['active'],
    data(){
        return {
            id: null,
            errors: new Errors({}),
            enviando: false
        }
    },

    watch: {
        active() {
            this.reset();
        }
    },

    computed: {
        buttonClass() {
            let classe = this.id ? 'is-success' : '';
            classe += this.enviando ? 'is-loading' : '';
            return classe;
        }
    },

    methods: {
        close(refresh = false) {
            this.reset();
            this.$emit('close', refresh);
        },
        reset() {
            this.errors.clear();
            this.id = null;
            this.$nextTick(() => {
                if (this.active === true) this.resetForm();
            });
        }
    }
}