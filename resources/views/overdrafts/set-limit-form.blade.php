@extends('layouts.app')
	@section('content')
		@isset($account)
			<div class="container mb-4">
				<h4>UPDATE YOUR BANK ACCOUNT OVERDRAFT</h4>
					<div class="row">
						<p class="lead mb-0">User name:  {{ $user->name }}</p>
						<p class="lead mb-0">User email: {{ $user->email }}</p>
						<br/><br/>
						<form method="POST" action="{{ route('updated') }}">         
							{{ csrf_field() }}
							<div class="mb-3">
								<label class="form-label" for="inputOverdraft">Set the overdraft:</label>
								<input type="number"
									id="overdraft"
									name="overdraft"
									min="1"
									value="{{ $account->overdraft }}"
									placeholder="Overdraft as a positive number greater than zero, e.g: 250"
									required>
								</input>
							</div>
							<div class="mb-3">
								<button class="btn btn-success btn-submit">Submit</button>
							</div>
						</form>
					</div>
			</div>	
		@endisset
		@empty($account)
			<script type="text/javascript">
				window.location = "{ url('/account/index') }";
			</script>
		@endempty
	@endsection
