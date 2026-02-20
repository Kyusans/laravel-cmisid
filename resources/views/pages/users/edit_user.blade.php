<!-- Still needs a lot of changes (unfinished, ignore for a while) -->

<x-layout>
    <!-- Replace title with variable -->
    <x-slot:title> Edit {{ $user->user_firstName }}'s Details</x-slot:title>

    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header">
            <h5 class="mb-0">{{ $user->user_firstName }} {{ $user->user_lastName }}</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="/user/details/{{ $user->user_id }}">
                @csrf
                @method('PUT')
                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">First Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user->user_firstName }}">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Middle Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user->user_middleName }}">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Last Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user->user_lastName }}">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Email:</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" value="{{ $user->user_email }}">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Role:</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option selected>{{ $user->role->role_name }}</option>
                            <option value="System Admin">System Admin</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Office:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $user->office->office_name }}">
                    </div>
                </div>
            <div class="col-2 mx-auto">
            <button type="submit" class="btn btn-primary mt-3">Update</button>
            </div>
            </form>
        </div>
    </div>
    </div>
</x-layout>