<!DOCTYPE html>
<html lang="en">

<x-admin-header-css></x-admin-header-css>

<body class="bg-login">

    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center">
                            <img src="assets/images/logo-img.png" width="180" alt="" />
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">Sign in</h3>
                                        <p>Don't have an account yet? <a href="authentication-signup.html">Sign up
                                                here</a>
                                        </p>
                                    </div>
                                    {{-- <div class="d-grid">
                                        <a class="btn my-4 shadow-sm btn-white" href="javascript:;"> <span
                                                class="d-flex justify-content-center align-items-center">
                                                <img class="me-2" src="assets/images/icons/search.svg" width="16"
                                                    alt="Image Description">
                                                <span>Sign in with Google</span>
                                            </span>
                                        </a> <a href="javascript:;" class="btn btn-facebook"><i
                                                class="bx bxl-facebook"></i>Sign in with Facebook</a>
                                    </div> --}}
                                    {{-- <div class="login-separater text-center mb-4"> <span>OR SIGN IN WITH
                                            EMAIL</span>
                                        <hr />
                                    </div> --}}
                                    <div class="form-body">
                                        <form class="row g-3" id="formSubmit">
                                            {{-- CSRF token not needed - route is excluded from CSRF verification --}}
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="inputEmailAddress"
                                                    name="email" placeholder="Email Address">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Enter
                                                    Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0"
                                                        id="inputChoosePassword" name="password"
                                                        placeholder="Enter Password"> <a href="javascript:;"
                                                        class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end"> <a
                                                    href="authentication-forgot-password.html">Forgot Password ?</a>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="bx bxs-lock-open"></i>Sign in</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->

    <x-admin-footer-js></x-admin-footer-js>

    <script>
    $(document).ready(function() {
                // Setup CSRF token for other AJAX requests (not for login)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#formSubmit").submit(function(e) {
                    $("#formSubmit").submit(function(e) {
                        e.preventDefault()
                        if ($(this).parsley().validate()) {
                            var url = "{{ url('login') }}";
                            // Get form data (no CSRF token since route is excluded)
                            var formData = $('#formSubmit').serialize();
                            // Make AJAX request - CSRF header will be sent by ajaxSetup but route is excluded
                            $.ajax({
                                url: url,
                                data: formData,
                                type: 'post',
                                success: function(result) {
                                    if (result.status == 200) {
                                        // Update CSRF token if provided for future requests
                                        if (result.csrf_token) {
                                            $('meta[name="csrf-token"]').attr('content',
                                                result.csrf_token);
                                            // Update global AJAX setup with new token
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': result
                                                        .csrf_token
                                                }
                                            });
                                        }
                                        window.location.href =
                                            "{{ url('admin/dashboard') }}";
                                    } else {
                                        alert('Wrong Credentials');
                                    }
                                },
                                error: function(xhr) {
                                    console.log(xhr);
                                    alert('Error: ' + (xhr.responseJSON?.message ||
                                        'Login failed'));
                                }
                            });
                        } else {
                            alert('Error Occurred');
                        }
                    });
                });
    </script>

</body>

</html>
