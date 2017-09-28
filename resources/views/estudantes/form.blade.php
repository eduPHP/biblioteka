{!! csrf_field() !!}

<!-- Input Matricula -->
<div class="field">
    <label class="label" for="matricula">Matricula</label>
    <div class="control{{ $errors->has('matricula') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('matricula') ? ' is-danger' : '' }}"
               name="matricula" id="matricula" value="{{
                    old('matricula',  isset($estudante) ? $estudante->matricula : null)
                }}">
        {!! $errors->has('matricula') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('matricula', '<p class="help is-danger">:message</p>') !!}
</div>
<!-- Input Nome -->
<div class="field">
    <label class="label" for="nome">Nome</label>
    <div class="control{{ $errors->has('nome') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('nome') ? ' is-danger' : '' }}"
               name="nome" id="nome" value="{{
                    old('nome',  isset($estudante) ? $estudante->nome : null)
                }}">
        {!! $errors->has('nome') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('nome', '<p class="help is-danger">:message</p>') !!}
</div>

<!-- Form Submit -->
<div class="field is-grouped">
    <div class="control">
        <button class="button is-{{isset($estudante)?'success':'info'}}">Gravar</button>
    </div>
    <div class="control">
        <button type="reset" class="button">Reset</button>
    </div>
</div>