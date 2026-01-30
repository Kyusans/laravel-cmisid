@extends("index")

@section("content")
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
      <form id="loginForm">
        @csrf
        <div class="form-group mb-3">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="login_email" aria-describedby="emailHelp"
            placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="login_password">Password</label>
          <input type="password" class="form-control" id="login_password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

  <script>
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const url = "/api/user/login"
      let email = document.getElementById("login_email").value;
      let password = document.getElementById("login_password").value;
      const jsonData = { "email": email, "password": password };
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify(jsonData)
      })
      const res = await response.json();
      console.log("res", res);

    })
  </script>
@endsection