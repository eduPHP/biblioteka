export default {
    replace: true,
    data(){
        return {
            search: '',
            filteredBy: '',
            loading: false,
            meta: {},
        }
    },

    watch: {
        filteredBy() {
            this.search = '';
            this.fetch(this.filteredBy === '' ? 1 : null);
        }
    },
    methods: {
        buscar() {
            this.filteredBy = this.search;
        },

        orderBy(field) {
            let direction = this.order.direction === 'asc' && this.order.field === field ? 'desc' : 'asc';

            this.order = {
                field,
                direction
            };
            this.fetch(1);
        }
    },
    mounted() {
        let searchInQuery = location.search.match(/q=([^&]+)/);
        let orderInQuery = location.search.match(/orderby=([a-z]+),(asc|desc)/);
        if (orderInQuery) {
            this.order = {
                field: orderInQuery[1],
                direction: orderInQuery[2]
            };
        }
        if (searchInQuery) {
            this.filteredBy = searchInQuery[1];
            return;
        }
        this.fetch();
    }
}