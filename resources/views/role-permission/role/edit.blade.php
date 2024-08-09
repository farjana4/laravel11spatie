<div class="container">
	<div class="raw">
		<div class="col-md-12">
			<div class="card">
				<h4>Edit Role
					<a href="{{url('roles')}}" class="btn btn-primary float-end">Back</a>
				</h4>
				<div class="card-body">
					<form action="{{url('roles/'.$role->id)}}" method="post">
						@csrf
						@method('PUT')
						<div class="mb-3">
							<label>Role Name</label>
							<input type="text" name="name" value="{{$role->name}}" class="form-control">
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