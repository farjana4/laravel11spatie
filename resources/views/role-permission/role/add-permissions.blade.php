<div class="container">
	<div class="raw">
		<div class="col-md-12">
			@if(session('status'))
				<div class="alert alert-success">{{session('status')}}</div>
			@endif
			<div class="card">
				<h4>Role: {{$role->name}}
					<a href="{{url('roles')}}" class="btn btn-primary float-end">Back</a>
				</h4>
				<div class="card-body">
					<form action="{{route('roles.give-permissions', $role->id)}}" method="post">
						@csrf
						@method('PUT')
						<div class="mb-3">
							@error('permission')
								<span class="text-ganger">{{$message}}</span>
							@enderror
							<label>Permissions</label>
							<div class="raw">
								@foreach($permissions as $permission)
									<div class="col-md-3">
										<label>
											<input 
												type="checkbox" 
												name="permission[]" 
												value="{{$permission->name}}"
												{{ in_array($permission->id, $rolePermissions) ? 'checked':''}} 
												class="form-control
											">
											{{$permission->name}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
						<div class="mb-3">
							<button type="submit" class="btn btn-primary">Update</button>
							
						</div>
					</form>
	
				</div>
			</div>
		</div>
	</div>
</div>