@foreach ($lineItems as $lineItem)
    @php($num = $loop->iteration)
    <x-lineItemRow :lineItem=$lineItem :num=$num />
@endforeach
