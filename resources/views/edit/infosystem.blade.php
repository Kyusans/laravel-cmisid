<!-- Still needs a lot of changes (unfinished, ignore for a while) -->

<x-layout>
    <!-- Replace title with variable -->
    <x-slot:title> Edit Information System's Details</x-slot:title>

    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header">
            <h5 class="mb-0">Information System Name</h5>
        </div>

        <div class="card-body">
            <form>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Rank:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="1">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Description:</label>
                    <div class="col-sm-8">
                        <textarea class="form-control">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  Excepteur sint occaecat cupida tat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </textarea>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Type:</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option selected value="Type 1">Type 1</option>
                            <option value="Type 2">Type 2</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Status:</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option selected value="Type 1">Status 1</option>
                            <option value="Type 2">Status 2</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Is a Smart City Initiative:</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option selected value="Type 1">Yes</option>
                            <option value="Type 2">No</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Office:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="Office Name">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Work Environment:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="Work Environment Name">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Development Strategy:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="Development Strategy Name">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">Has PIA:</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option selected value="Type 1">Yes</option>
                            <option value="Type 2">No</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">PIA Date:</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control">
                    </div>
                </div>

                <div class="d-flex mb-2 form-group">
                    <label class="col-sm-3 col-form-label fw-semibold">PIA Initiation Year:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="Development Strategy Name">
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