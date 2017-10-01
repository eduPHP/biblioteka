<template>
    <nav class="pagination" role="navigation" aria-label="pagination" v-if="lastPage>1">
        <a class="pagination-previous" title="This is the first page" disabled v-if="page===1">Anterior</a>
        <a @click="page--" rel="prev" class="pagination-previous" v-else>Anterior</a>
        <p class="pagination-list">Página {{ page }} de {{ lastPage }}</p>
        <a @click="page++" rel="next" class="pagination-next" v-if="page < lastPage">Próxima</a>
        <a class="pagination-next" title="This is the last page" disabled v-else>Próxima</a>
    </nav>
</template>

<script>
    export default {
        props: ['meta'],
        data(){
            return {
                page: 1,
                lastPage: 1
            };
        },
        watch: {
            meta(){
                this.page = this.meta.current_page;
                this.lastPage = this.meta.last_page;
            },
            page() {
                this.$emit('changed', this.page);
            }
        }
    }
</script>
<style>
    .pagination-list {
        justify-content : flex-end;
    }
</style>
