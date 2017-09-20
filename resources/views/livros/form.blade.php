{!! csrf_field() !!}

<!-- Input Isbn -->
<div class="form-group{{ $errors->has('isbn') ? ' has-error' : '' }}">
    <label for="isbn" class="col-sm-2 control-label">ISBN</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="isbn" name="isbn" value="{{
            old('isbn',  isset($livro->isbn) ? $livro->isbn : null)
        }}">
        {!! $errors->first('isbn', '<span class="label label-danger">:message</span>') !!}
    </div>
</div>


<!-- Input Titulo -->
<div class="form-group{{ $errors->has('titulo') ? ' has-error' : '' }}">
    <label for="titulo" class="col-sm-2 control-label">Titulo</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{
            old('titulo',  isset($livro) ? $livro->titulo : null)
        }}">
        {!! $errors->first('titulo', '<span class="label label-danger">:message</span>') !!}
    </div>
</div>


<!-- Form Submit -->
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-{{isset($livro)?'success':'info'}}">Gravar</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </div>
</div>