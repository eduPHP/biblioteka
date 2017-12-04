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
import Auth from '../directives/auth';
import QueryOn from '../directives/query'

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
            paths: {},
            auth: new Auth(window.User),
            query: null
        }
    },

    computed: {
        defaultOrder() {
            return {
                field: 'nome',
                direction: 'asc'
            };
        },
        indexPath() {
            return this.paths.index();
        },

        defaultQuery(){
            return [];
        }
    },

    watch: {
        filteredBy() {
            this.search = '';
            this.fetch(1);
        }
    },
    methods: {
        can(action) {
            return this.auth.can(action)
        },

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

            if (!page) page = this.query.get('page', 1);
            this.query.add('page', page);

            this.query.add('orderby', `${this.order.field},${this.order.direction}`);
            if (this.filteredBy !== '') {
                this.query.add('q', this.filteredBy);
            }

            this.loading = true;
            axios.get(`${this.indexPath}?${this.query.full()}`).then(response => {
                this.itens = response.data[this.basePath];
                this.meta = response.data.meta;
                this.loading = false;
            });
            this.query.setLocation(`orderby=${this.defaultOrder.field},${this.defaultOrder.direction}`);
        }
    },
    created() {
        this.paths = new PathFinder(this.basePath);
        this.order = _.clone(this.defaultOrder);
    },
    mounted() {
        this.query = new QueryOn();
        this.query.parse();
        if (this.query.has('orderby')) {
            let orderInQuery = this.query.match('orderby', /([a-z]+),(asc|desc)/);
            this.order = {
                field: orderInQuery[1],
                direction: orderInQuery[2]
            };
        }
        if (this.query.has('q')) {
            this.filteredBy = this.query.get('q');
            return;
        }
        this.fetch();
    }
}