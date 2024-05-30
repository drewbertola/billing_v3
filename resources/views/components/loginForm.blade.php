<div class="col-md-6 mx-auto my-4">
    <p>Please Login</p>
    <p id="loginMessage" class="text-danger"></p>
    <form id="login-form">
        @csrf
        <input id="referrer" type="hidden" name="referrer" value="" >
        <label class="form-label" for="email">Email</label>
        <input class="form-control mb-2" type="email" id="email" name="email" />
        <label class="form-label" for="password">Password</label>
        <input class="form-control mb-2" type="password" id="password" name="password" />
        <button type="submit" class="btn btn-primary mt-2 float-end"
            hx-post="/login"
            hx-target="#loginMessage"
        >Login</button>
    </form>
</div>
