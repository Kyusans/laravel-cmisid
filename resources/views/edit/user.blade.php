<!-- Still needs a lot of changes (unfinished, ignore for a while) -->

<x-layout>
    <!-- Replace title with variable -->
    <x-slot:title>Firstname's Details</x-slot:title>

    <div class="card col-6 mt-3 mx-auto">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $user_data['firstname'] . ' ' . $user_data['lastname']}}</h5>
            <a href="#" class="text-decoration-none text-muted">
                <i class="bi bi-pencil"></i>
            </a>
        </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="john@email.com">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="123-456-7890">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="123 Main St">
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</x-layout>