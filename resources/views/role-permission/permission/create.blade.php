<div class="container">
	<div class="raw">
		<div class="col-md-12">
			<div class="card">
				<h4>Permission
					<a href="{{url('permissions')}}" class="btn btn-primary float-end">Back</a>
				</h4>
				<div class="card-body">
					<form action="{{ url('permissions') }}" method="post">
						@csrf
						<div class="mb-3">
							<label>Permission Name</label>
							<input type="text" name="name" class="form-control">
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
