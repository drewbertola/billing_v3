@guest
    <x-loginForm />
@endguest

@auth
    @if ($customer['id'] == '0')
        <p>Add Customer</p>
    @else
        <p>Update Customer</p>
    @endif
    <p class="text-danger text-center fw-bold" id="saveResult"></p>
    <form class="m-4">
        @csrf
        <p class="fw-bold mt-4 mb-2">Company</p>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="name">Name</label>
            <input class="col-md-9" type="text" name="name" id="name" value="{{$customer['name']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="phoneMain">Phone</label>
            <input class="col-md-9" type="text" name="phoneMain" id="phoneMain" value="{{$customer['phoneMain']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="fax">Fax</label>
            <input class="col-md-9" type="text" name="fax" id="fax" value="{{$customer['fax']}}" />
        </div>
        <p class="fw-bold mt-4 mb-2">Primary Contact</p>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="primaryContact">Name</label>
            <input class="col-md-9" type="text" name="primaryContact" id="primaryContact" value="{{$customer['primaryContact']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="primaryEmail">Email</label>
            <input class="col-md-9" type="text" name="primaryEmail" id="primaryEmail" value="{{$customer['primaryEmail']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="primaryPhone">Phone</label>
            <input class="col-md-9" type="text" name="primaryPhone" id="primaryPhone" value="{{$customer['primaryPhone']}}" />
        </div>

        <p class="fw-bold mt-4 mb-2">Billing Contact</p>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="billingContact">Name</label>
            <input class="col-md-9" type="text" name="billingContact" id="billingContact" value="{{$customer['billingContact']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="billingEmail">Email</label>
            <input class="col-md-9" type="text" name="billingEmail" id="billingEmail" value="{{$customer['billingEmail']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="billingPhone">Phone</label>
            <input class="col-md-9" type="text" name="billingPhone" id="billingPhone" value="{{$customer['billingPhone']}}" />
        </div>
        <p class="fw-bold mt-4 mb-2">Billing Address</p>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="bAddress1">Address 1</label>
            <input class="col-md-9" type="text" name="bAddress1" id="bAddress1" value="{{$customer['bAddress1']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="bAddress2">Address 2</label>
            <input class="col-md-9" type="text" name="bAddress2" id="bAddress2" value="{{$customer['bAddress2']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="bCity">City</label>
            <input class="col-md-9" type="text" name="bCity" id="bCity" value="{{$customer['bCity']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="bState">State</label>
            <input class="col-md-9" type="text" name="bState" id="bState" value="{{$customer['bState']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="bZip">Zip</label>
            <input class="col-md-9" type="text" name="bZip" id="bZip" value="{{$customer['bZip']}}" />
        </div>
        <p class="fw-bold mt-4 mb-2">Shipping Address</p>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="sAddress1">Address 1</label>
            <input class="col-md-9" type="text" name="sAddress1" id="sAddress1" value="{{$customer['sAddress1']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="sAddress2">Address 2</label>
            <input class="col-md-9" type="text" name="sAddress2" id="sAddress2" value="{{$customer['sAddress2']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="sCity">City</label>
            <input class="col-md-9" type="text" name="sCity" id="sCity" value="{{$customer['sCity']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="sState">State</label>
            <input class="col-md-9" type="text" name="sState" id="sState" value="{{$customer['sState']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="sZip">Zip</label>
            <input class="col-md-9" type="text" name="sZip" id="sZip" value="{{$customer['sZip']}}" />
        </div>
        <p class="fw-bold mt-4 mb-2">Other Info</p>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="taxRate">Tax Rate</label>
            <input class="col-md-9" type="text" name="taxRate" id="taxRate" value="{{$customer['taxRate']}}" />
        </div>
        <div class="row mb-2">
            <label class="col-form-label col-md-3" for="archive">Archive</label>
            <div class="form-check form-switch col-md-9">
                <input class="form-check-input" type="checkbox" name="archive" id="archive"
                @if ($customer['archive'] === 'Y')
                    checked
                @endif
                />
            </div>
        </div>
        <div class="form-group row justify-content-between">
            <button type="button" class="btn btn-secondary col-4 col-md-2 mt-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary col-4 col-md-2 mt-2" data-bs-dismiss="modal"
                hx-post=/customers/save/{{$customer['id']}}
                hx-trigger="click"
                hx-target="#customerRow{{$customer['id']}}"
                @if (empty($customer['id']))
                    hx-swap="beforebegin"
                @else
                    hx-swap="outerHTML"
                @endif
            >Save</button>
        </div>
    </form>
@endauth
