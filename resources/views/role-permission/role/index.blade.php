@include('role-permission.nav-links')
<div class="container">
	<div class="raw">
		<div class="col-md-12">
			@if(session('status'))
				<div class="alert alert-success">{{session('status')}}</div>
			@endif
			<div class="card mt-3">
				<h4>Role
					<a href="{{url('roles/create')}}" class="btn btn-primary float-end">add Role</a>
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
							@foreach($roles as $role)
							<tr>
								<td>{{$role->id}}</td>
								<td>{{$role->name}}</td>
								<td>
									@can('add-edit role permission')
									<a href="{{url('roles/'.$role->id.'/give-permissions')}}">Add/ Edit Role Permission</a>
									@endcan
									@can('update role')
									<a href="{{url('roles/'.$role->id.'/edit')}}">Edit</a>
									@endcan
									@can('delete role')
									<form action="{{url('roles/'.$role->id)}}" method="post">
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


