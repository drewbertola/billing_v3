<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        @if ($lineItem['id'] === 0)
            <p>Add Line Item</p>
        @else
            <p>Update Line Item</p>
        @endif
    @endauth
</x-layout>
