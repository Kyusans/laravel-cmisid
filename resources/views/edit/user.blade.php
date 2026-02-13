<!-- Still needs a lot of changes (unfinished, ignore for a while) -->

<x-layout>
    <!-- Replace title with variable -->
    <x-slot:title> {{ $user_data['firstname'] }}'s Details</x-slot:title>

    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header">
            <h5 class="mb-0">{{ $user_data['firstname'] . ' ' . $user_data['lastname']}}</h5>
        </div>

        <div class="card-body">
            <form>
                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">First Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user_data['firstname'] }}">
                    </div>
                </div>
                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Last Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user_data['lastname'] }}">
                    </div>
                </div>
                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Email:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user_data['email'] }}">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Role:</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option selected value="{{ $user_data['role'] }}">{{ $user_data['role'] }}</option>
                            <option value="System Admin">System Admin</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Office:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user_data['office'] }}">
                    </div>
                </div>
            </form>
            <div class="col-2 mx-auto">
            <button type="button" class="btn btn-primary mt-3">Update</button>
            </div>
        </div>
    </div>
    </div>
</x-layout>