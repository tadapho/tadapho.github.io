<html>

<head>
    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #F5E8F7;
            height: 100vh;
        }

        #login .container #login-row #login-column #login-box #frm_login {
            padding: 20px;
        }

        .has-error {
            border: 1px solid red;
        }
    </style>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="login">

        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form name="frm_login" class="form" id="frm_login">

                            <h3 class="text-center text-info">Login</h3>
                            <div class="mb-3">
                                <label for="username" class="text-info">Username:</label>
                                <input type="text" class="form-control" size="10px" id="username"
                                    name="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="text-info">Password:</label>
                                <input type="password" class="form-control" size="10px" id="password"
                                    name="password">
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary" onclick="login()">Sign In</button>
                            </div>
                            <p>Not a member? <a href="#!">Register</a></p>
                            <div id="err" style="color: red"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        function login() {
            if ($('#username').val() == "") {
                $('#username').addClass('has-error');
                return false;
            } else if ($('#password').val() == "") {
                $('#password').addClass('has-error');
                return false;
            } else {
                var data = $("#frm_login").serialize();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '/check',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response == 1) {
                            window.location.replace('/home');
                        } else if (response == 3) {
                            $("#err").hide().html("Username or Password  Incorrect. Please Check").fadeIn(
                                'slow');
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>
