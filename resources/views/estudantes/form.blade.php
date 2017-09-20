{!! csrf_field() !!}

<!-- Input Matricula -->
<div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
    <label for="matricula" class="col-sm-2 control-label">Matricula</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="matricula" name="matricula" value="{{
            old('matricula',  isset($estudante) ? $estudante->matricula : null)
        }}">
        {!! $errors->first('matricula', '<span class="label label-danger">:message</span>') !!}
    </div>
</div>


<!-- Input Nome -->
<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
    <label for="nome" class="col-sm-2 control-label">Nome</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nome" name="nome" value="{{
            old('nome',  isset($estudante) ? $estudante->nome : null)
        }}">
        {!! $errors->first('nome', '<span class="label label-danger">:message</span>') !!}
    </div>
</div>



<!-- Form Submit -->
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-{{isset($estudante)?'success':'info'}}">Gravar</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </div>
</div>