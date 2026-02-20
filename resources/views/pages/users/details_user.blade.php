<x-layout>
  <!-- Replace title with variable -->
  <x-slot:title>{{ $user->user_firstName }} Details</x-slot:title>

  <div class="card mx-auto" style="max-width: 500px;">
    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">{{ $user->user_firstName . ' ' . $user->user_lastName }}</h5>
      <a href="/user/edit/{{ $user->user_id }}" class="text-decoration-none text-muted">
        <i class="bi bi-pencil"></i>
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Full Name:</dt>
        <dd class="col-sm-8">{{ $user->user_firstName }} {{ $user->user_middleName }} {{ $user->user_lastName }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Email:</dt>
        <dd class="col-sm-8">{{ $user->user_email }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Role:</dt>
        <dd class="col-sm-8">{{ $user->role->role_name }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Office:</dt>
        <dd class="col-sm-8">{{ $user->office->office_name }}</dd>
      </dl>

      <dl class="d-flex mb-2 row">
        <dt class="fw-semibold col-sm-3">Created at:</dt>
        <dd class="col-sm-8">{{ $user->created_at->diffForHumans() }}</dd>
      </dl>

    </div>

  </div>
  </div>
</x-layout>