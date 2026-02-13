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

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Full Name:</dt>
        <dd class="col-sm-8">{{ $user_data['firstname'] }} {{ $user_data['middlename'] }} {{ $user_data['lastname'] }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Email:</dt>
        <dd class="col-sm-8">{{ $user_data['email'] }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Role:</dt>
        <dd class="col-sm-8">{{ $user_data['role'] }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Office:</dt>
        <dd class="col-sm-8">{{ $user_data['office'] }}</dd>
      </dl>

    </div>

  </div>
  </div>
</x-layout>