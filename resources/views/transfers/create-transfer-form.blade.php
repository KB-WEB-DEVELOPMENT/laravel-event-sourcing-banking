@extends('layouts.app')
	@section('content')
		@isset($account)
			<div class="container mb-4">
				<div class="row">
					<div class="col-lg-12">
						<p class="lead mb-0">User name:  {{ $user->name }}</p>
						<p class="lead mb-0">User email: {{ $user->email }}</p>
						<br/>
						<h4>Transfer funds to another bank account</h4>
						<form method="POST" action="{{ route('transfers-submitted') }}">         
							{{ csrf_field() }}
							<div class="mb-3">
								<label class="form-label" for="inputOverdraft">Creditor Bank Account ID:</label>
								<input type="text"
									id="creditor_account_uuid"
									name="creditor_account_uuid"
									placeholder="A proper bank account ID (here which follows the UUID format), e.g:
									916045a8-4630-4b1d-8c8c-d2f5a0064b06"
									pattern="[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}"
									required>
								</input>
								<input type="number"
									id="amount"
									name="amount"
									step="0.01"
									min="0.01"
									placeholder="Money amount as 2 decimals positive number, e.g: 102.99"
									required>
								</input>
							</div>
							<div class="mb-3">
								<button class="btn btn-success btn-submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		@endisset
		@empty($account)
			<script type="text/javascript">
				window.location = "{ url('/account/index') }";
			</script>
		@endempty		
	@endsection
