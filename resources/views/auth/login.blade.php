<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | LANTERA</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-theme.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }
    </style>
</head>


<body>

    <div class="container-fluid">
        <div class="row" style="min-height: 100vh;">
            <!-- LEFT -->
            <div class="col-lg-6 d-none d-lg-flex bg-light d-flex align-items-center justify-content-center">



                <div class="text-center px-4">
                    <h3 class="font-weight-bold mb-3" style="font-size: 24px; color:#333;">
                        SELAMAT DATANG
                    </h3>
                    <p class="mb-4" style="font-size: 14px; color:#666;">
                        DI LANTERA SMPN 1 BALEN
                    </p>
                    <img src="{{ asset('img/loginImage.jpeg') }}" class="img-fluid" style="max-width: 400px;"
                        alt="login">
                </div>
            </div>
            
            <!-- RIGHT -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('img/logoClean.png') }}" alt="LANTERA" style="width: 80px; margin-bottom: 10px;">
                                        <h1 class="h4 text-gray-900 mb-2 font-weight-bold">Selamat datang Kembali!</h1>
                                        <p class="text-muted small">Masuk ke akun Anda untuk melanjutkan</p>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="number"
                                                class="form-control form-control-user @error('nomor_identitas') is-invalid @enderror"
                                                id="nomor_identitas" name="nomor_identitas" aria-describedby="emailHelp"
                                                placeholder="Nomor Identitas">
                                            @error('nomor_identitas')
                                                <span class="text-danger small d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Password">
                                            @error('password')
                                                <span class="text-danger small d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a href="{{ route('register') }}" class="small">Membuat Akun!</a>
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

</body>

</html>
