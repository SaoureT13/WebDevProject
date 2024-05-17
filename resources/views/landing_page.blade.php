<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/style_landing_page.css'])
    @include('favicon_import')
</head>

<body>
    <div class="container">
        <div class="layout">
            <div class="layout-wrapper">
                <header class="header">
                    <nav>
                        <div class="menu-block">
                            <a href="#">
                                <img src="{{ asset('img/logo-pg.png') }}" alt="logo" width="140" height="44" />
                            </a>
                            <ul class="menu">
                                <li><a href="{{ route('student.signup') }}">Sign in</a></li>
                                <li><a href="{{ route('student.login') }}" class="button">Login</a></li>
                            </ul>
                            <div class="menu-icon">
                                <div class="menu-btn open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
                                        <line x1="4" x2="20" y1="12" y2="12" />
                                        <line x1="4" x2="20" y1="6" y2="6" />
                                        <line x1="4" x2="20" y1="18" y2="18" />
                                    </svg>
                                </div>
                            </div>
                            <div class="overlay"></div>
                            <div class="header__mobile">
                                <div class="header__mobile-content">
                                    <div class="menu-btn close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                            <path d="M18 6 6 18" />
                                            <path d="m6 6 12 12" />
                                        </svg>
                                    </div>
                                    <a href="{{ route('student.signup') }}">Sign up</a>
                                    <a href="{{ route('student.login') }}">Log in</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </header>
                <main class="main">
                    <div class="content">
                        <h1>Pigier Landing Page</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor reiciendis labore corrupti maiores recusandae fugiat?</p>

                        <div class="btn-box">
                        <a href="{{ route('student.signup') }}" class="button-get-started">Get started</a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script>
        const menuIcons = document.querySelectorAll(".menu-btn");
        const overlay = document.querySelector(".overlay");
        const headerMobile = document.querySelector(".header__mobile");

        menuIcons.forEach((icon) => {
            icon.addEventListener("click", (e) => {
                e.preventDefault();

                overlay.classList.toggle("active");
                headerMobile.classList.toggle("active");
            });
        });

        overlay.addEventListener("click", (e) => {
            e.preventDefault();

            overlay.classList.toggle("active");
            headerMobile.classList.remove("active");
        });
    </script>
</body>

</html>