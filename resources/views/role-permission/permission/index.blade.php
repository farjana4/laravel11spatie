@include('role-permission.nav-links')
<div class="container">
	<div class="raw">
		<div class="col-md-12">
			@if(session('status'))
				<div class="alert alert-success">{{session('status')}}</div>
			@endif
			<div class="card mt-3">
				<h4>Permission
					<a href="{{url('permissions/create')}}" class="btn btn-primary float-end">add Permission</a>
				</h4>
				<div class="card-body">
					
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($permissions as $permission)
							<tr>
								<td>{{$permission->id}}</td>
								<td>{{$permission->name}}</td>
								<td>
									@can('update permission')
									<a href="{{url('permissions/'.$permission->id.'/edit')}}">Edit</a>
									@endcan
									@can('delete permission')
									<form action="{{url('permissions/'.$permission->id)}}" method="post">
										@csrf
										@method('DELETE')
									
										<button>Delete</button>
									</form>
									@endcan
								</td>
							</tr>
							@endforeach
						</tbody>

						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


