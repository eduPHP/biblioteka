{!! csrf_field() !!}

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

<!-- Input Titulo -->
<div class="field">
    <label class="label" for="titulo">Titulo</label>
    <div class="control{{ $errors->has('titulo') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('titulo') ? ' is-danger' : '' }}"
               name="titulo" id="titulo" value="{{
                    old('titulo',  isset($livro) ? $livro->titulo : null)
                }}">
        {!! $errors->has('titulo') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('titulo', '<p class="help is-danger">:message</p>') !!}
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