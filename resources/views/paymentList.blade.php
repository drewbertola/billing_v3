<x-layout :isHtmxRequest=$isHtmxRequest>
    @guest
        <x-loginForm />
    @endguest

    @auth
        <p>Payments List</p>
    @endauth
</x-layout>
