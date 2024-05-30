<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <p>LineItems List</p>
    @endauth
</x-layout>
