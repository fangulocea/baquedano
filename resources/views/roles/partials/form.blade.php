<div class="form-group">
	{{ Form::label('name', 'Nombre de la etiqueta') }}
	{{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
</div>
<div class="form-group">
	{{ Form::label('slug', 'URL Amigable') }}
	{{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) }}
</div>
<div class="form-group">
	{{ Form::label('description', 'Descripción') }}
	{{ Form::textarea('description', null, ['class' => 'form-control']) }}
</div>
<hr>
<h3>Permiso especial</h3>
<div class="form-group">
 	<label>{{ Form::radio('special', 'all-access') }} Acceso total</label>
 	<label>{{ Form::radio('special', 'no-access') }} Ningún acceso</label>
</div>
<hr>
<h3>Lista de permisos</h3>
<div class="table-responsive">
            <table id="listusers" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>Permiso</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Check</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($permissions as $permission)
                            <tr>
                                <td>{{ Form::checkbox('permissions[]', $permission->id, null) }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description }}</td>
                                
                            </tr>
                            @endforeach

                </tbody>
            </table>
        </div>


 <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
</div>
