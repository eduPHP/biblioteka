class QueryOn {
    constructor() {
        this.query = {};
    }

    parse() {
        if (window.location.search === ''){
            this.query = {};
            return;
        }

        window.location.search.split('?')[1].split('&').forEach((item)=>{
            let separated = item.split('=');
            let key = separated[0];
            let value = separated[1];

            this.add(key, value);
        });

        return this;
    }

    add(key, value) {
        window.Vue.set(this.query, key, value);
    }

    has(key) {
        return this.query.hasOwnProperty(key);
    }

    get(key, defaultReturn = null) {
        if (this.query[key]) {
            return this.query[key];
        }

        return defaultReturn;
    }

    match(key, regex){
        return this.get(key).match(regex);
    }

    remove(key) {
        window.Vue.delete(this.query, key);
    }

    full(){
        let fullQuery = [];
        for (let [key, value] of Object.entries(this.query)) {
            fullQuery.push(`${key}=${value}`);
        }

        return fullQuery.join('&');
    }

    setLocation(skipWhen = ''){
        let update = this.full();

        if (update === skipWhen) {
            history.pushState(null, document.title, location.href.split("?")[0]);
            return;
        }

        history.pushState(null, document.title, '?' + update);
    }
}

export {QueryOn as default};