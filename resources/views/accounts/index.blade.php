@extends('layouts.app')

@section('content')
   <div class="container mb-4">
        <div class="row">
            <div class="col-lg-12">
                <p class="lead mb-0">User name:  {{ $user->name }}</p>
				<p class="lead mb-0">User email: {{ $user->email }}</p>
				<h4>Account Infos</h4>
				@isset($account)
					<p class="lead mb-0">Account id: {{ $account->account_uuid }}</p>
					<p class="lead mb-0">Balance: {{ $account->balance }}</p>
					<p class="lead mb-0">Overdraft: {{ $account->overdraft }}</p>
				@endisset
				@empty($account)
					<form method="POST" action="/account/created">
						@method('PUT')
						<button type="button">Create account</button>
					</form>	
				@endempty
			</div>	
		</div>
		@isset($account)
			<div class="row">
				<div style="inline-block;padding:5px;" class="col-lg-12">
					<button type="button" href="{{ route('withdraw') }}">Withdraw funds from your account</button>
					<button type="button" href="{{ route('deposit') }}">Deposit funds on your account</button>
					<button type="button" href="{{ route('update') }}">Update your overdraft</button>			
					<button type="button" href="{{ route('transfers-index') }}">Transfer funds to another bank account</button>	
					<form method="POST" action="/account/closed">
						@method('PUT')
						<button type="button">Close account</button>
					</form>
				</div>
			</div>
		@endisset
    </div>
@endsection
