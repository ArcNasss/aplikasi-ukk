<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | LENTERA</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>


<body class="bg-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- LEFT -->
                            <div class="col-lg-6 d-none d-lg-flex bg-white position-relative d-flex align-items-center">

                                <!-- LOGO -->
                                <div class="position-absolute"
                                    style="top: 30px; left: 40px; font-weight: 900; font-size: 20px;">
                                    <span style="color:#000;">LAN</span><span class="text-primary">TERA</span>
                                </div>

                                <!-- CENTER CONTENT -->
                                <div class="w-100 text-center px-4">

                                    <h3 class="font-weight-bold mb-1" style="font-size: 24px; color:#000;">
                                        SELAMAT DATANG
                                    </h3>

                                    <p class="font-weight-bold mb-4" style="font-size: 14px; color:#000;">
                                        DI LANTERA SMPN 1 BALEN
                                    </p>

                                    <img src="{{ asset('img/loginImage.jpeg') }}" class="img-fluid mt-3 w-75"
                                        alt="login">

                                </div>

                            </div>
                            <!-- RIGHT -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Masukkan Akun!</h1>
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
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Ingat Aku</label>
                                            </div>
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
