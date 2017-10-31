class LoadingState {
    constructor() {
        this.loading = {};
    }

    set(field) {
        window.Vue.set(this.loading, field, true);
    }

    has(field) {
        return this.loading.hasOwnProperty(field);
    }

    done(field) {
        delete this.loading[field];
    }

    any() {
        return Object.keys(this.loading).length;
    }
}

export {LoadingState as default};