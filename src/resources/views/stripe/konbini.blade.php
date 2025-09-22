@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $item->name }} のコンビニ支払い</h2>
    <p>金額: ¥{{ number_format($item->price) }}</p>

    <button id="konbini-button">コンビニで支払う</button>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");

    document.getElementById('konbini-button').addEventListener('click', async () => {
        const { error } = await stripe.confirmKonbiniPayment(
            "{{ $clientSecret }}",
            {
                payment_method: {
                    billing_details: {
                        name: "{{ Auth::user()->name }}",
                        email: "{{ Auth::user()->email }}",
                    },
                },
                return_url: "{{ route('purchase.success', ['item_id' => $item->id]) }}"
            }
        );

        if (error) {
            alert(error.message);
        }
    });
</script>
@endsection
