class Errors {
    constructor(errors) {
        this.errors = errors;
    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    any() {
        return !!Object.keys(this.errors).length;
    }

    first(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    add(field, message) {
        window.Vue.set(this.errors, field, [message]);
    }

    remove(field) {
        window.Vue.delete(this.errors,field);
    }

    record(errors) {
        this.errors = errors;
    }
}

export {Errors as default};