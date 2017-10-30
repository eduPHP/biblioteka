{!! csrf_field() !!}

<div class="columns">
    <div class="column">
        <!-- Input Isbn -->
        <div class="field">
            <label class="label" for="isbn">ISBN</label>
            <div class="control{{ $errors->has('isbn') ? ' has-icons-right' : '' }}">
                <input class="input{{ $errors->has('isbn') ? ' is-danger' : '' }}"
                       name="isbn" id="isbn" value="{{
                    old('isbn',  isset($livro) ? $livro->isbn : null)
                }}">
                {!! $errors->has('isbn') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('isbn', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
    <div class="column">
        <!-- Input Quantidade -->
        <div class="field">
            <label class="label" for="quantidade">Quantidade Disponível</label>
            <div class="control{{ $errors->has('quantidade') ? ' has-icons-right' : '' }}">
                <input class="input{{ $errors->has('quantidade') ? ' is-danger' : '' }}"
                       name="quantidade" id="quantidade" value="{{
                            old('quantidade',  isset($livro) ? $livro->quantidade : null)
                        }}">
                {!! $errors->has('quantidade') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('quantidade', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
</div>
<div class="columns">
    <div class="column is-half-tablet">
        <!-- Select Autores -->
        <div class="field">
            <label class="label is-marginless" for="autores">Autores <span class="subtitle is-7">(0)</span></label>
            <div class="control{{ $errors->has('autores') ? ' has-icons-left' : '' }}">
                <select-autores></select-autores>
                {!! $errors->has('autores') ? '<span class="icon is-small is-left"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('autores', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
</div>

<!-- Input Titulo -->
<div class="field">
    <label class="label" for="titulo">Título</label>
    <div class="control{{ $errors->has('titulo') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('titulo') ? ' is-danger' : '' }}"
               name="titulo" id="titulo" value="{{
                    old('titulo',  isset($livro) ? $livro->titulo : null)
                }}">
        {!! $errors->has('titulo') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('titulo', '<p class="help is-danger">:message</p>') !!}
</div>

<!-- Textarea Descricao -->
<div class="field">
    <label class="label" for="descricao">Descrição</label>
    <div class="control{{ $errors->has('descricao') ? ' has-icons-right' : '' }}">
        <textarea class="textarea{{ $errors->has('descricao') ? ' is-danger' : '' }}"
        id="descricao" name="descricao" rows="3">{{
            old('descricao',  isset($livro) ? $livro->descricao : null)
        }}</textarea>
        {!! $errors->has('descricao') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('descricao', '<p class="help is-danger">:message</p>') !!}
</div>

<div class="columns">
    <div class="column">
        <!-- Select Editora -->
        <div class="field">
            <label class="label" for="editora_id">Editora</label>
            <div class="control{{ $errors->has('editora_id') ? ' has-icons-left' : '' }}">
                <select-editoras></select-editoras>
                {!! $errors->has('editora_id') ? '<span class="icon is-small is-left"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('editora_id', '<p class="help is-danger">:message</p>') !!}
        </div>

    </div>
    <div class="column">
        <!-- Select Secao -->
        <div class="field">
            <label class="label" for="secao_id">Seção</label>
            <div class="control{{ $errors->has('secao_id') ? ' has-icons-left' : '' }}">
                <select-secoes></select-secoes>
                {!! $errors->has('secao_id') ? '<span class="icon is-small is-left"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('secao_id', '<p class="help is-danger">:message</p>') !!}
        </div>

    </div>
</div>

<div class="columns">
    <div class="column">
        <!-- Input Ano -->
        <div class="field">
            <label class="label" for="ano">Ano</label>
            <div class="control{{ $errors->has('ano') ? ' has-icons-right' : '' }}">
                <input class="input{{ $errors->has('ano') ? ' is-danger' : '' }}"
                       name="ano" id="ano" value="{{
                            old('ano',  isset($livro) ? $livro->ano : null)
                        }}">
                {!! $errors->has('ano') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('ano', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
    <div class="column">
        <!-- Input Edicao -->
        <div class="field">
            <label class="label" for="edicao">Edição</label>
            <div class="control{{ $errors->has('edicao') ? ' has-icons-right' : '' }}">
                <input class="input{{ $errors->has('edicao') ? ' is-danger' : '' }}"
                       name="edicao" id="edicao" value="{{
                            old('edicao',  isset($livro) ? $livro->edicao : null)
                        }}">
                {!! $errors->has('edicao') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
            </div>
            {!! $errors->first('edicao', '<p class="help is-danger">:message</p>') !!}
        </div>
    </div>
</div>

<!-- Form Submit -->
<div class="field is-grouped">
    <div class="control">
        <button class="button is-{{isset($livro)?'success':'info'}}">Gravar</button>
    </div>
    <div class="control">
        <button type="reset" class="button">Reset</button>
    </div>
</div>