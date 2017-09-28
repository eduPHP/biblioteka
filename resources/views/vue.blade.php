@extends('layouts.app')

@section('content')

    <testando :model="{{$livro}}"></testando>
@endsection

@section('javascript')
    @parent
    <script>
        Vue.component('testando', {
            props: ['model'],
            data(){
                return {
                    property: this.model
                }
            },
            template: `<p> Livro @{{ property.titulo }} </p>`
        });
        new Vue({
            el: '#app'
        });
    </script>

@stop