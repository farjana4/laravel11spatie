<div class="container">
	<div class="raw">
		<div class="col-md-12">
			<div class="card">
				<h4>Create User
					<a href="{{url('users')}}" class="btn btn-primary float-end">Back</a>
				</h4>
				<div class="card-body">
					<form action="{{ url('users') }}" method="post">
						@csrf
						<div class="mb-3">
							<label>Name</label>
							<input type="text" name="name" class="form-control">
							@error('name')<span class="text-danger">{{$message}}</span>@enderror
						</div>
						<div class="mb-3">
							<label>Email</label>
							<input type="text" name="email" class="form-control">
							@error('email')<span class="text-danger">{{$message}}</span>@enderror
						</div>
						<div class="mb-3">
							<label>Password</label>
							<input type="password" name="password" class="form-control">
							@error('password')<span class="text-danger">{{$message}}</span>@enderror
						</div>
						<div class="mb-3">
							<label>Role</label>
							<select name="roles[]" class="form-control" multiple>
								<option>Select Role</option>
								@foreach($roles as $role)
									<option value="{{$role}}">{{$role}}</option>
								@endforeach
							</select>
							@error('roles')<span class="text-danger">{{$message}}</span>@enderror
						</div>
						<div class="mb-3">
							<button type="submit" class="btn btn-primary">Save</button>
							
						</div>
					</form>
	
				</div>
			</div>
		</div>
	</div>
</div>