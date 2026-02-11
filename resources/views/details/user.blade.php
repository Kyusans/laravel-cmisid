<x-layout>
    <!-- Replace title with variable -->
    <x-slot:title>Firstname's Details</x-slot:title>

    <div class="card mb-4 mt-3 mx-auto" style="max-width: 500px;">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $user_data['firstname'] . ' ' . $user_data['lastname']}}</h5>
            <a href="#" class="text-decoration-none text-muted">
                <i class="bi bi-pencil"></i>
            </a>
        </div>

        <!-- Body -->
 <div class="card-body">

    <div class="d-flex mb-2">
      <div class="fw-semibold me-2">Email:</div>
      <div>{{ $user_data['email'] }}</div>
    </div>

    <div class="d-flex mb-2">
      <div class="fw-semibold me-2">Role:</div>
      <div>{{ $user_data['role'] }}</div>
    </div>

    <div class="d-flex">
      <div class="fw-semibold me-2">Office:</div>
      <div>{{ $user_data['office'] }}</div>
    </div>

  </div>

    </div>
    </div>
</x-layout>