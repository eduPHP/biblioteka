{!! csrf_field() !!}

<!-- Input Descricao -->
<div class="field">
    <label class="label" for="descricao">Descrição</label>
    <div class="control{{ $errors->has('descricao') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('descricao') ? ' is-danger' : '' }}"
               name="descricao" id="descricao" value="{{
                    old('descricao',  isset($secao) ? $secao->descricao : null)
                }}">
        {!! $errors->has('descricao') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('descricao', '<p class="help is-danger">:message</p>') !!}
</div>
<!-- Input Localizacao -->
<div class="field">
    <label class="label" for="localizacao">Localização</label>
    <div class="control{{ $errors->has('localizacao') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('localizacao') ? ' is-danger' : '' }}"
               name="localizacao" id="localizacao" value="{{
                    old('localizacao',  isset($secao) ? $secao->localizacao : null)
                }}">
        {!! $errors->has('localizacao') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('localizacao', '<p class="help is-danger">:message</p>') !!}
</div>


<!-- Form Submit -->
<div class="field is-grouped">
    <div class="control">
        <button class="button is-{{isset($secao)?'success':'info'}}">Gravar</button>
    </div>
    <div class="control">
        <button type="reset" class="button">Reset</button>
    </div>
</div>