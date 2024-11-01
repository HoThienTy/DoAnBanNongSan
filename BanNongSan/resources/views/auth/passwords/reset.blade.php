<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template - Đặt lại mật khẩu">
    <meta name="keywords" content="Ogani, unica, creative, html, password reset">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogani | Đặt lại mật khẩu</title>

    <!-- Bao gồm CSS -->
    @include('layouts.vendor-css')
</head>
<style>
    /* Custom styles for login and register forms */
    .login,
    .register {
        padding-top: 100px;
        padding-bottom: 100px;
    }

    .login__form,
    .register__form {
        background: #f5f5f5;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
    }

    .login__form h3,
    .register__form h3 {
        margin-bottom: 30px;
        font-weight: 700;
    }

    .input__item {
        position: relative;
        margin-bottom: 20px;
    }

    .input__item input {
        width: 100%;
        padding: 15px 45px 15px 20px;
        border: 1px solid #ebebeb;
        border-radius: 50px;
    }

    .input__item span {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        font-size: 20px;
        color: #b2b2b2;
    }

    .site-btn {
        width: 100%;
        text-align: center;
        border-radius: 50px;
        margin-top: 20px;
    }

    .forget_pass,
    .create_acc,
    .have_acc {
        display: block;
        margin-top: 15px;
        color: #6f6f6f;
        text-decoration: underline;
    }

    .forget_pass:hover,
    .create_acc:hover,
    .have_acc:hover {
        color: #7fad39;
    }
</style>
<body>
    <!-- Header Begin -->
    @include('layouts.header')
    <!-- Header End -->

    <!-- Password Reset Section Begin -->
    <section class="password-reset spad">
        <div class="container">
            <div class="login__form">
                <h3>Đặt lại mật khẩu</h3>
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input__item">
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Địa chỉ email" required>
                        <span class="icon_mail"></span>
                    </div>
                    <div class="input__item">
                        <input type="password" name="mat_khau" placeholder="Mật khẩu mới" required>
                        <span class="icon_lock"></span>
                    </div>
                    <div class="input__item">
                        <input type="password" name="mat_khau_confirmation" placeholder="Xác nhận mật khẩu" required>
                        <span class="icon_check"></span>
                    </div>
                    <button type="submit" class="site-btn">Đặt lại mật khẩu</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Password Reset Section End -->

    <!-- Footer Begin -->
    @include('layouts.footer')
    <!-- Footer End -->

    <!-- Bao gồm JS -->
    @include('layouts.vendor-js')
</body>
</html>
