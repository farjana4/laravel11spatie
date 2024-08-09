@include('role-permission.nav-links')
<div class="container">
	<div class="raw">
		<div class="col-md-12">
			@if(session('status'))
				<div class="alert alert-success">{{session('status')}}</div>
			@endif
			<div class="card mt-3">
				<h4>Role
					<a href="{{url('users/create')}}" class="btn btn-primary float-end">add User</a>
				</h4>
				<div class="card-body">
					
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
							<tr>
								<td>{{$user->id}}</td>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>@if(!empty($user->getRoleNames()))
										@foreach($user->getRoleNames() as $rolename)
											<label class="badge bg-primary mx-1">{{$rolename}}</label>
										@endforeach
									@endif
									</td>
								<td>
									@can('update user')
									<a href="{{url('users/'.$user->id.'/edit')}}">Edit</a>
									@endcan
									@can('delete user')
									<form action="{{route('users.destroy', $user->id)}}" method="post">
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


