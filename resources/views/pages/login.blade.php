@extends("index")

@section("content")
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
      <form action="{{ route("user.login") }}" method="POST">
        @csrf

        <div class="form-floating mb-3">
          <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
          <label for="email">Email address</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>

        <div class="d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-outline-dark mt-3">Submit</button>
        </div>

        {{-- validation errors ni --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

      </form>
    </div>
  </div>
@endsection