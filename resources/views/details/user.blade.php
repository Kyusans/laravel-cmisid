<x-layout>
  <!-- Replace title with variable -->
  <x-slot:title>{{ $user_data['firstname'] }} Details</x-slot:title>

  <div class="card mx-auto" style="max-width: 500px;">
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
        <div class="fw-semibold col-sm-3">Email:</div>
        <div>{{ $user_data['email'] }}</div>
      </div>

      <div class="d-flex mb-2">
        <div class="fw-semibold col-sm-3">Role:</div>
        <div>{{ $user_data['role'] }}</div>
      </div>

      <div class="d-flex mb-2">
        <div class="fw-semibold col-sm-3">Office:</div>
        <div>{{ $user_data['office'] }}</div>
      </div>

    </div>

  </div>
  </div>
</x-layout>