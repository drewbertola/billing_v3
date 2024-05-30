<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        @if ($payment['id'] === 0)
            <p>Add Payment</p>
        @else
            <p>Update Payment</p>
        @endif
    @endauth
</x-layout>
