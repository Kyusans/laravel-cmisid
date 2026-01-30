@extends("index")

@section("content")
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
      <form id="loginForm">
        @csrf

        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="login_email" placeholder="name@example.com" required>
          <label for="login_email">Email address</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="login_password" placeholder="Password" required>
          <label for="login_password">Password</label>
        </div>

        <div class="d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-outline-dark mt-3">Submit</button>
        </div>
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