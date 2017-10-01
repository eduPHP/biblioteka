@extends('layouts.app')
@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li>
                <a href="{{ url('/') }}"> <span class="icon is-small">
                        <i class="fa fa-home"></i></span><span>{{ config('app.name') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/emprestimos') }}">
                    <span class="icon is-small"><i class="fa fa-book"></i></span> <span>Emprestimos</span>
                </a>
            </li>
            <li class="is-active">
                <span class="icon is-small"><i class="fa fa-plus"></i></span> Adicionar Emprestimo
            </li>
        </ul>
    </nav>
    <h1 class="title">Adicionar Emprestimo</h1>
    <form action="{{ url('/emprestimos') }}" method="POST" class="form-horizontal">
        {!! method_field("POST") !!}

        {!! csrf_field() !!}

        <div class="columns">
            <div class="column">

                <!-- Input Livros -->
                <div class="field">
                    <div class="control has-icons-right">
                        <input class="input{{ $errors->has('livros') ? ' is-danger' : '' }}"
                               name="livros" id="livros" value="{{
                    old('livros')
                }}" placeholder="Informe o ISBN e pressione enter">
                        <span class="icon is-small is-right"><i class="fa fa-barcode"></i></span>
                    </div>
                    {!! $errors->first('livros', '<p class="help is-danger">:message</p>') !!}
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="level">
                            <h4 class="title is-4 level-left">Test</h4>
                            <button class="delete level-right" type="button"></button>
                        </div>
                        <div class="content">
                            <p>ISBN: 1234</p>
                        </div>
                    </div>
                    <hr />
                    <div class="card-content">
                        <div class="level">
                            <h4 class="title is-4 level-left">Test</h4>
                            <button class="delete level-right" type="button"></button>
                        </div>
                        <div class="content">
                            <p>ISBN: 1234</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="column">
                <!-- Input Estudante_id -->
                <div class="field">
                    <div class="control{{ $errors->has('estudante_id') ? ' has-icons-right' : '' }}">
                        <input class="input{{ $errors->has('estudante_id') ? ' is-danger' : '' }}"
                               name="estudante_id" id="estudante_id" value="{{
                    old('estudante_id')
                }}" placeholder="Estudante">
                        {!! $errors->has('estudante_id') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
                    </div>
                    {!! $errors->first('estudante_id', '<p class="help is-danger">:message</p>') !!}
                </div>


                <!-- Input Devolucao -->
                <datepicker placeholder="Devolução, padrão {{ \Carbon\Carbon::now()->addWeek()->format('d/m/Y') }}"></datepicker>

            </div>
        </div>


            <!-- Form Submit -->
            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-info">Gravar</button>
                </div>
                <div class="control">
                    <button type="reset" class="button">Reset</button>
                </div>
            </div>


    </form>
@endsection
@section('style')
    @parent
    <style>
        .card-content {
            padding : 0.3rem 0.7rem;
        }
        hr {
            margin: 0.4rem 0 0
        }

        .level:not(:last-child) {
             margin-bottom: 0;
        }

        .title:not(:last-child){
            margin-bottom : 0.2rem;
        }
        .calendar{
            max-width: 23rem;
            min-width: 23rem;
        }
    </style>
@stop