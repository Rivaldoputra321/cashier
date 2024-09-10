<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="bg">
    <div class="container full-height-center">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-12">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="{{ asset('img/kasir.jpeg') }}" alt="">
                            </div>
                            <div class="col-lg-6">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <h2 class="text-center mt-4">Login Admin</h2>
                                    <div class="p-5">
                                        
                                    @if (session('success'))
                                        <div>
                                            <p class="sucsess">{{ session('success') }}</p>
                                        </div>
                                    @endif

                                    @if(Session::has('error'))
                                        <p id="flash-message" class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ Session::get('error') }}
                                        </p>
                                    @endif
                                        <div class="form-group mb-4">
                                            
                                            <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" autofocus>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group mb-4">
                                            <div class="input-group">
                                                <input name="password" id="password" type="password" class="form-control " placeholder="Password" value="{{ old('password') }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                                        <i class="bi bi-eye-fill" id="toggle-icon"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary mb-4">Log In</button>
                                        
                                </form>
                                
                                
                                <div class="text-center">
                                    <a class="small" href="register">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Password Toggle Script -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle icon
            const toggleIcon = document.getElementById('toggle-icon');
            toggleIcon.classList.toggle('bi-eye-fill');
            toggleIcon.classList.toggle('bi-eye-slash-fill');
        });

        document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var flashMessage = document.getElementById('flash-message');
            if(flashMessage) {
                flashMessage.style.transition = 'opacity 0.5s ease';
                flashMessage.style.opacity = '0';
                setTimeout(function() {
                    flashMessage.style.display = 'none';
                }, 500); // 0.5 detik waktu transisi sebelum hilang sepenuhnya
            }
        }, 3000); // Waktu dalam milidetik (3000ms = 3 detik)
    });
    </script>
</body>

</html>
