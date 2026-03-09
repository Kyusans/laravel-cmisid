<!-- Still needs a lot of changes (unfinished, ignore for a while) -->

<x-layout>
    <!-- Replace title with variable -->
    <x-slot:title>Create User</x-slot:title>

    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header">
            <h5 class="mb-0">Create User</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="/create/user">
                @csrf
                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">First Name:</label>
                    <div class="col-sm-8">
                        <input name="userFirstName" type="text" class="form-control">
                    </div>
                </div>
                @error('userFirstName')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Middle Name:</label>
                    <div class="col-sm-8">
                        <input name="userMiddleName" type="text" class="form-control">
                    </div>
                </div>
                @error('userMiddleName')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Last Name:</label>
                    <div class="col-sm-8">
                        <input name="userLastName" type="text" class="form-control">
                    </div>
                </div>
                @error('userLastName')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Email:</label>
                    <div class="col-sm-8">
                        <input name="userEmail" type="email" class="form-control">
                    </div>
                </div>
                @error('userEmail')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Password:</label>
                    <div class="col-sm-8">
                        <input name="userPassword" type="password" class="form-control">
                    </div>
                </div>
                @error('userPassword')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Role:</label>
                    <div class="col-sm-8">
                        <select name="userRoleId" class="form-select">
                            <option selected>Choose...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('userRoleId')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Office:</label>
                    <div class="col-sm-8">
                        <select name="userOfficeId" class="form-select">
                            <option selected>Choose...</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->office_id }}">{{ $office->office_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('userOfficeId')
                    <div class="label mb-2">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror
                <div class="col-2 mx-auto">
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</x-layout>
