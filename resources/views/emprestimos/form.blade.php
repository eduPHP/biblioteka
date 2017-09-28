{!! csrf_field() !!}

<!-- Input Estudante_id -->
<div class="field">
    <label class="label" for="estudante_id">Estudante_id</label>
    <div class="control{{ $errors->has('estudante_id') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('estudante_id') ? ' is-danger' : '' }}"
               name="estudante_id" id="estudante_id" value="{{
                    old('estudante_id',  isset($emprestimo) ? $emprestimo->estudante_id : null)
                }}">
        {!! $errors->has('estudante_id') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('estudante_id', '<p class="help is-danger">:message</p>') !!}
</div>

<!-- Input Livros -->
<div class="field">
    <label class="label" for="livros">Livros</label>
    <div class="control{{ $errors->has('livros') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('livros') ? ' is-danger' : '' }}"
               name="livros" id="livros" value="{{
                    old('livros',  isset($emprestimo) ? $emprestimo->livros : null)
                }}">
        {!! $errors->has('livros') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('livros', '<p class="help is-danger">:message</p>') !!}
</div>


<!-- Input Devolucao -->
<div class="field">
    <label class="label" for="devolucao">Devolucao</label>
    <div class="control{{ $errors->has('devolucao') ? ' has-icons-right' : '' }}">
        <input class="input{{ $errors->has('devolucao') ? ' is-danger' : '' }}"
               name="devolucao" id="devolucao" value="{{
                    old('devolucao',  isset($emprestimo) ? $emprestimo->devolucao : null)
                }}">
        {!! $errors->has('devolucao') ? '<span class="icon is-small is-right"><i class="fa fa-warning"></i></span>' : ''  !!}
    </div>
    {!! $errors->first('devolucao', '<p class="help is-danger">:message</p>') !!}
</div>


<!-- Form Submit -->
<div class="field is-grouped">
    <div class="control">
        <button class="button is-{{isset($emprestimo)?'success':'info'}}">Gravar</button>
    </div>
    <div class="control">
        <button type="reset" class="button">Reset</button>
    </div>
</div>