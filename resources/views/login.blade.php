<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema de Control Escolar - UP Nochixtlán</title>

    <!-- Custom fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            height: 100vh;
            background: #8A1010;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            height: 100vh;
            display: flex;
            position: relative;
        }

        .left-section {
            flex: 1;
            background: #8A1010;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background-image {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .center-image {
            top: -55px;
            position: relative;
            z-index: 10;
            max-width: 600px;
            max-height: 600px;
            width: 560px;
            height: 560px;
            object-fit: contain;
        }



        .decorative-shapes {
            display: none;
        }

        .shape-1 {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .shape-2 {
            position: absolute;
            bottom: -30%;
            left: -15%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .shape-3 {
            position: absolute;
            top: 20%;
            left: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .logo-container {
            display: none;
        }

        .logo {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #8FBC8F 0%, #228B22 50%, #006400 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        .logo::before {
            content: '';
            position: absolute;
            width: 60%;
            height: 60%;
            background: linear-gradient(45deg, #A0522D 0%, #8B4513 100%);
            border-radius: 50%;
            z-index: 1;
        }

        .logo-text {
            font-size: 36px;
            font-weight: 900;
            color: white;
            z-index: 2;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .university-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .university-subtitle {
            font-size: 18px;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .university-author {
            font-size: 16px;
            font-weight: 300;
            opacity: 0.8;
            font-style: italic;
        }

        .right-section {
            flex: 1;
            background: #8A1010;
            display: flex;
            align-items: center;
            position: relative;
        }

        .login-form-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 65px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 400px;

            margin-left: 100px;
        }

        .form-title {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 26px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: none;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            color: #333;
            outline: none;
        }

        .form-control:focus {
            background: white;
        }

        .form-control::placeholder {
            color: #666;
        }

        .form-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: #5B8736;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #71ac41;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            color: white;
            text-decoration: underline;
        }

        .mountain-silhouette {
            display: none;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .left-section {
                flex: 0.4;
                padding: 20px;
            }

            .right-section {
                flex: 0.6;
            }

            .logo {
                width: 100px;
                height: 100px;
            }

            .logo-text {
                font-size: 24px;
            }

            .university-name {
                font-size: 20px;
            }

            .university-subtitle {
                font-size: 14px;
            }

            .university-author {
                font-size: 12px;
            }

            .form-title {
                font-size: 20px;
            }

            .login-form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Section for Images -->
        <div class="left-section">
            <div class="image-container">


                <img src="{{ asset('libs/sbadmin/img/fondo.png') }}" alt="Background" class="background-image"
                    oncontextmenu="return false;" ondragstart="return false;" onselectstart="return false;"
                    style="pointer-events: none; user-select: none;">

                <img src="{{ asset('libs/sbadmin/img/up_logo.png') }}" alt="Center Logo" class="center-image"
                    oncontextmenu="return false;" ondragstart="return false;" onselectstart="return false;"
                    style="pointer-events: none; user-select: none;">
            </div>
        </div>

        <!-- Right Section with Login Form -->
        <div class="right-section">
            <div class="login-form-container">
                <h2 class="form-title">SISTEMA DE<br>CONTROL ESCOLAR</h2>


                <form class="login-form" method="POST" action="{{ route('login.post') }}">
                    @csrf <!-- Protección CSRF -->

                    <div class="form-group">
                        <i class="fas fa-user form-icon"></i>
                        <input type="text" name="username" class="form-control" placeholder="Usuario" required>
                    </div>

                    <div class="form-group">
                        <i class="fas fa-lock form-icon"></i>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>

                    <button type="submit" class="btn-login">
                        Iniciar Sesión
                    </button>

                    <div class="forgot-password">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Basic functionality only
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll('.form-control');

            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });

        const style = document.createElement('style');
        style.textContent = `
            .focused .form-icon {
                color: #228B22 !important;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
