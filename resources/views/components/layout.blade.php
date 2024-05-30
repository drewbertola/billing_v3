@props(['isHtmxRequest'])

@empty($isHtmxRequest)
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name')}}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/billing.css?v=1">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/htmx.org@1.9.12" integrity="sha384-ujb1lZYygJmzgSwoxRggbCHcjc0rB2XoQrxeTUQyRjrOnlCoYta87iKBWq3EsdM2" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="/js/billing.js?v=1"></script>
    </head>
    <body id="body" class="mx-2 mx-md-auto">
        <nav class="navbar navbar-expand-md bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand ms-4" href="">{{config('app.navBrand')}}</a>
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navMain"
                    aria-controls="navbarNavAltMarkup"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="bi bi-list text-white"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMain">
                    <div class="navbar-nav me-auto mb-2 mb-md-0">
                        <a href="" id="customersNav"
                            class="nav-link ms-4"
                            hx-get="/customers"
                            hx-trigger="click"
                            hx-target="#content"
                            hx-push-url="true">Customers</a>
                        <a href="" id="invoicesNav"
                            class="nav-link ms-4"
                            hx-get="/invoices"
                            hx-trigger="click"
                            hx-target="#content"
                            hx-push-url="true">Invoices</a>
                        <a href="" id="paymentsNav"
                            class="nav-link ms-4"
                            hx-get="/payments"
                            hx-trigger="click"
                            hx-target="#content"
                            hx-push-url="true">Payments</a>
                    </div>
                    <div class="navbar-nav ms-auto mb-2 mb-md-0">
                        <a href="" id="logoutNav"
                            class="nav-link me-4"
                            hx-get="/logout"
                            hx-trigger="click"
                            hx-target="#content"
                            hx-push-url="true">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="m-4">
            <main id="content">
<!-- end header -->
@endempty

{{ $slot }}

@empty($isHtmxRequest)
<!-- start footer -->
            </main>
            <footer>
            </footer>
        </div>
    </body>
</html>
@endempty
