@extends('layouts.app')
	@section('content')
		@isset($account)
			<div class="container mb-4">
				<h4>WITHDRAW FUNDS FROM YOUR ACCOUNT</h4>
					<div class="row">
						<p class="lead mb-0">User name:  {{ $user->name }}</p>
						<p class="lead mb-0">User email: {{ $user->email }}</p>
						<br/><br/>
						<form method="POST" action="{{ route('withdrawn') }}">         
							{{ csrf_field() }}
							<div class="mb-3">
								<label class="form-label" for="inputWithdrawalAmount">Amount:</label>
								<input type="number"
								   id="amount"
								   name="amount"
								   step="0.01"
								   min="0.01"
								   placeholder="Money amount as a 2 decimals positive number, e.g: 102.99"
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
