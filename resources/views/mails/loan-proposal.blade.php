@component('mail::message')
	# Loan proposal

	It seems like you are having financial troubles. Contact us for a loan.

	@component('mail::button', ['url' => 'https://github.com/KB-WEB-DEVELOPMENT'])
		View proposal
	@endcomponent

	Thanks,<br>
	Your bank
@endcomponent
