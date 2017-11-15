export default {
    replace: true,
    data(){
        return {
            editando: false,
            editResource: null
        }
    },

    methods: {
        editar(resource) {
            this.editando = true;
            this.editResource = resource;
        },
        fecharEdicao(refresh = false) {
            this.editando = false;
            this.editResource = null;
            if (refresh === true) {
                this.fetch();
            }
        }
    }
}