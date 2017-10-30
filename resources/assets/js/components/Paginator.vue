<template>
    <nav class="pagination" role="navigation" aria-label="pagination" v-if="lastPage>1">
        <a class="pagination-previous" title="This is the first page" disabled v-if="page===1">Anterior</a>
        <a @click="page--" rel="prev" class="pagination-previous" v-else>Anterior</a>
        <a @click="page++" rel="next" class="pagination-next" v-if="page < lastPage">Próxima</a>
        <a class="pagination-next" title="This is the last page" disabled v-else>Próxima</a>
        <ul class="pagination-list">
            <li v-for="pg in pages">
                <span class="pagination-ellipsis" v-if="pg === '...'">&hellip;</span>
                <a class="pagination-link is-current" v-if="pg === page" aria-current="page">{{ pg }}</a>
                <a @click="page = pg" class="pagination-link" v-if="pg !== page && pg !== '...'">{{ pg }}</a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['meta'],
        data(){
            return {
                page: 1,
                total: 0,
                lastPage: 1,
                perPage:  10,
                pages: []
            };
        },
        watch: {
            meta(){
                this.page = this.meta.current_page;
                this.lastPage = this.meta.last_page;
                this.perPage = this.meta.per_page;
                this.parsePages();
            },
            page() {
                this.$emit('changed', this.page);
            }
        },
        methods: {
            parsePages() {
                this.pages = [];

                if (this.lastPage < this.perPage * 2 + 6) {
                    for (let i = 1; i < this.lastPage + 1; i++) {
                        this.pages.push(i);
                    }
                }
                else if (this.page < this.perPage * 2 + 1) {
                    for (let i = 1; i < this.perPage * 2 + 4; i++) {
                        this.pages.push(i);
                    }
                    this.pages.push('...');
                    this.pages.push(this.lastPage);
                }
                else if (this.page > this.lastPage - this.perPage * 2) {
                    this.pages.push(1);
                    this.pages.push('...');
                    for (let i = this.lastPage - this.perPage * 2 - 2; i < this.lastPage + 1; i++) {
                        this.pages.push(i);
                    }
                }
                else {
                    this.pages.push(1);
                    this.pages.push('...');
                    for (let i = this.page - this.perPage; i < this.page + this.perPage + 1; i++) {
                        this.pages.push(i);
                    }
                    this.pages.push('...');
                    this.pages.push(this.lastPage);
                }
            }
        }
    }
</script>
<style>
    /*.pagination-list {*/
        /*justify-content : flex-end;*/
    /*}*/
</style>
