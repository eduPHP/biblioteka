class PathFinder {
    constructor(base) {
        this.base = base;
    }

    index() {
        return `/api/${this.base}`;
    }

    destroy(model) {
        return `/api/${this.base}/${model.id}`;
    }
}

import formActions from "../mixins/formActions";

export default {
    mixins: [formActions],
    replace: true,
    data() {
        return {
            order: {},
            search: '',
            filteredBy: '',
            loading: false,
            meta: {},
            basePath: 'base',
            itens: [],
            paths: {}
        }
    },

    computed: {
        defaultOrder() {
            return {
                field: 'nome',
                direction: 'asc'
            };
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

        orderBy(field, defaultDirection = 'asc') {
            let direction = this.getOrderDirection(field, defaultDirection);

            this.order = {
                field,
                direction
            };

            this.fetch(1);
        },

        getOrderDirection(field, defaultDirection) {
            let invert = defaultDirection === 'asc' ? 'desc' : 'asc';
            return this.order.direction === defaultDirection && this.order.field === field ? invert : defaultDirection;
        },

        fetch(page) {
            if (this.loading) {
                return;
            }
            let query = [];
            if (!page) {
                let pageInQuery = location.search.match(/page=(\d+)/);
                page = pageInQuery ? parseInt(pageInQuery[1]) : 1;
            }
            if (page > 1) query.push(`page=${page}`);

            query.push(`orderby=${this.order.field},${this.order.direction}`);
            if (this.filteredBy !== '') {
                query.push(`q=${this.filteredBy}`);
            }

            this.loading = true;
            axios.get(`${this.paths.index()}?${query.join('&')}`).then(response => {
                this.itens = response.data[this.basePath];
                this.meta = response.data.meta;
                this.loading = false;
            });
            this.updateLocation(query);
        },
        updateLocation(query) {
            let update = query.join('&');
            if (update === `orderby=${this.defaultOrder.field},${this.defaultOrder.direction}`) {
                history.pushState(null, document.title, location.href.split("?")[0]);
                return;
            }

            history.pushState(null, document.title, '?' + update);
        }
    },
    created() {
        this.paths = new PathFinder(this.basePath);
        this.order = _.clone(this.defaultOrder);
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