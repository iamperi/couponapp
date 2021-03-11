<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('css')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        <div class="flex flex-col min-h-screen bg-gray-100">
            <header class="relative flex items-center justify-between w-screen h-20 bg-red-700 px-12 sm:px-20"
                    x-data="{mobileMenuOpen: false}"
            >
                <a href="https://mostoleapp.com">
                    <img src="{{ asset('img/logo-blanco.png') }}" alt="Logo Móstoles" />
                </a>

                <nav class="hidden md:block">
                    <ul class="flex list-none">
                        <li class="text-white no-underline ml-6">
                            <a href="https://mostoleapp.com/shop">Ofertas y Descuentos</a>
                        </li>
                        <li class="text-white no-underline ml-6">
                            <a href="https://mostoleapp.com/blog">Blog</a>
                        </li>
                        <li class="text-white no-underline ml-6">
                            <a href="https://mostoleapp.com/micuenta">Entrar</a>
                        </li>
                        @can(\App\Constants::ACCESS_ADMIN)
                        <li class="text-white no-underline ml-6">
                            <a href="{{ route('admin.index') }}">Admin</a>
                        </li>
                        @endcan
                    </ul>
                </nav>
                <div class="block md:hidden" @click="mobileMenuOpen = !mobileMenuOpen">
                    <img src="{{ asset('img/icons/notes-white.svg') }}" class="w-8 cursor-pointer">
                </div>
                <nav class="block md:hidden absolute w-full bg-red-700 top-0 left-0 mt-20 py-4 border-t-2 border-red-800 shadow-lg"
                     x-show="mobileMenuOpen">
                    <ul class="flex flex-col list-none">
                        <li class="text-white text-lg no-underline ml-6 py-2">
                            <a href="https://mostoleapp.com/shop">Ofertas y Descuentos</a>
                        </li>
                        <li class="text-white text-lg no-underline ml-6 py-2">
                            <a href="https://mostoleapp.com/blog">Blog</a>
                        </li>
                        <li class="text-white text-lg no-underline ml-6 py-2">
                            <a href="https://mostoleapp.com/micuenta">Entrar</a>
                        </li>
                    </ul>
                </nav>
            </header>

            <main class="flex-grow my-10 px-8 md:mx-0">
                @if(session('error'))
                    <div class="bg-red-100 text-red-600 text-center border-2 border-red-400 p-2 m-6 rounded shadow">
                        <label>{{session('error')}}</label>
                    </div>
                @endif
                {{ $slot }}
            </main>

            <footer class="mt-4 w-full text-white">
                <div class="flex flex-col md:flex-row px-0 py-12 md:p-12 bg-red-700">
                    <div class="w-full md:w-2/5 px-8">
                        <div>
                            <img src="{{ asset('img/logo-blanco.png') }}" alt="Logo Móstoles" class="h-6" />
                        </div>
                        <p class="mt-4 text-xs">
                            Nuestro propósito es dar a conocer al pequeño comerciante de la ciudad de Móstoles. Descubrirás que tienes de
                            todo cerca de tu hogar sin necesidad de desplazarte. ¡Anímate a explorar y aprovecha las promociones
                            disponibles!
                        </p>
                        <p class="mt-4 text-xs">
                            MóstoleApp ha sido promovido por Móstoles Desarrollo.
                        </p>
                        <p>
                            Para más información: 916 85 30 90 / info@mostoleapp.com
                        </p>
                    </div>
                    <div class="flex w-full md:w-3/5 px-8 mt-8 md:mt-0">
                        <div class="flex flex-col w-1/2 mr-4">
                            <h6 class="text-sm font-normal mb-4">INFORMACIÓN</h6>
                            <a href="https://mostoleapp.com/como-instalar-nuestra-app/" class="mb-2 text-sm">Cómo instalar nuestra App PWA</a>
                            <a href="https://mostoleapp.com/shop/" class="mb-2 text-sm">Ofertas y cupones</a>
                            <a href="https://mostoleapp.com/blog/" class="mb-2 text-sm">Artículos y consejos</a>
                            <a href="https://mostoleapp.com/solicitud-de-acceso-a-datos/" class="mb-2 text-sm">Solicitud de acceso a datos</a>
                            <a href="https://mostoleapp.com/tos/" class="mb-2 text-sm">Términos del servicio</a>
                            <a href="https://mostoleapp.com/politica-privacidad/" class="mb-2 text-sm">Política de privacidad</a>
                        </div>

                        <div class="flex flex-col w-1/2 ml-4">
                            <h6 class="text-sm font-normal mb-4">AYUDA</h6>
                            <a href="https://mostoleapp.com/how-it-works/" class="mb-2 text-sm">¿Cómo funciona?</a>
                            <a href="https://mostoleapp.com/preguntas-frecuentes" class="mb-2 text-sm">Preguntas frecuentes</a>
                            <a href="https://mostoleapp.com/soy-comerciante/" class="mb-2 text-sm">¿Cómo puedo dar de alta mi negocio en la App?</a>
                        </div>

                    </div>
                </div>

                <div class="flex flex-wrap w-full bg-gray-900 text-blue-100 px-8 py-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center w-full mx-auto px-8 max-w-7xl">
                        <samp class="text-xs">Copyright mostoleapp © 2021. All Rights Reserved</samp>
                        <ul class="flex items-center mt-8 sm:mt-0">
                            <a href="https://www.facebook.com/mostoles.desarrollo/" class="">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                        <path
                                            d="M17.5845 13.5L18.2512 9.15675H14.0835V6.33825C14.0835 5.15025 14.6655 3.9915 16.5322 3.9915H18.4267V0.293998C18.4267 0.293998 16.7077 0.000747681 15.0637 0.000747681C11.6317 0.000747681 9.38849 2.08125 9.38849 5.847V9.1575H5.57324V13.5007H9.38849V24.0007H14.0835V13.5007L17.5845 13.5Z"
                                            fill="#A1B5D6" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>

                            <a href="https://twitter.com/mostdesarrollo" class="ml-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.643 4.93699C22.808 5.30699 21.911 5.55699 20.968 5.66999C21.941 5.08778 22.669 4.17145 23.016 3.09199C22.1019 3.63497 21.1014 4.01718 20.058 4.22199C19.3564 3.47285 18.4271 2.97631 17.4143 2.80946C16.4016 2.64261 15.3621 2.81478 14.4572 3.29924C13.5524 3.7837 12.8328 4.55335 12.4102 5.48869C11.9875 6.42403 11.8855 7.47274 12.12 8.47199C10.2677 8.37898 8.45564 7.89753 6.80144 7.05889C5.14723 6.22025 3.68785 5.04315 2.51801 3.60399C2.11801 4.29399 1.88801 5.09399 1.88801 5.94599C1.88757 6.71298 2.07644 7.46823 2.43789 8.14472C2.79934 8.82121 3.32217 9.39802 3.96001 9.82399C3.22029 9.80045 2.49688 9.60057 1.85001 9.24099V9.30098C1.84994 10.3767 2.22204 11.4194 2.90319 12.252C3.58434 13.0846 4.53258 13.6559 5.58701 13.869C4.9008 14.0547 4.18135 14.0821 3.48301 13.949C3.78051 14.8746 4.36001 15.684 5.14038 16.2639C5.92075 16.8438 6.86293 17.1652 7.83501 17.183C6.18485 18.4784 4.1469 19.1811 2.04901 19.178C1.67739 19.1781 1.30609 19.1564 0.937012 19.113C3.06649 20.4822 5.54535 21.2088 8.07701 21.206C16.647 21.206 21.332 14.108 21.332 7.95199C21.332 7.75199 21.327 7.54999 21.318 7.34999C22.2293 6.69096 23.0159 5.87488 23.641 4.93999L23.643 4.93699V4.93699Z"
                                        fill="#A1B5D6" />
                                </svg>
                            </a>

                            <a href="https://www.instagram.com/mostoles_desarrollo/" class="ml-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.75 0H2.25C1.0125 0 0 1.0125 0 2.25V21.75C0 22.9875 1.0125 24 2.25 24H21.75C22.9875 24 24 22.9875 24 21.75V2.25C24 1.0125 22.9875 0 21.75 0ZM16.5 3.75C16.5 3.3375 16.8375 3 17.25 3H20.25C20.6625 3 21 3.3375 21 3.75V6.75C21 7.1625 20.6625 7.5 20.25 7.5H17.25C17.0512 7.4996 16.8607 7.42046 16.7201 7.27989C16.5795 7.13933 16.5004 6.94879 16.5 6.75V3.75ZM12 7.5C13.1734 7.5303 14.2885 8.0177 15.1077 8.85831C15.9268 9.69892 16.3853 10.8263 16.3853 12C16.3853 13.1737 15.9268 14.3011 15.1077 15.1417C14.2885 15.9823 13.1734 16.4697 12 16.5C10.8266 16.4697 9.71152 15.9823 8.89234 15.1417C8.07315 14.3011 7.6147 13.1737 7.6147 12C7.6147 10.8263 8.07315 9.69892 8.89234 8.85831C9.71152 8.0177 10.8266 7.5303 12 7.5V7.5ZM21 20.25C21 20.6625 20.6625 21 20.25 21H3.75C3.55121 20.9996 3.36067 20.9205 3.22011 20.7799C3.07954 20.6393 3.0004 20.4488 3 20.25V10.5H4.65C4.42726 11.5898 4.44978 12.7156 4.71593 13.7956C4.98208 14.8757 5.48519 15.883 6.1888 16.7446C6.89241 17.6061 7.77889 18.3004 8.78399 18.7769C9.78909 19.2535 10.8876 19.5005 12 19.5C13.1124 19.5005 14.2109 19.2535 15.216 18.7769C16.2211 18.3004 17.1076 17.6061 17.8112 16.7446C18.5148 15.883 19.0179 14.8757 19.2841 13.7956C19.5502 12.7156 19.5727 11.5898 19.35 10.5H21V20.25Z"
                                        fill="#A1B5D6" />
                                </svg>
                            </a>

                            <a href="https://www.linkedin.com/in/m%C3%B3stoles-desarrollo-22178653" class="ml-4">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M2.7206e-07 1.838C2.7206e-07 1.35053 0.193646 0.883032 0.538338 0.53834C0.88303 0.193648 1.35053 2.45031e-06 1.838 2.45031e-06H20.16C20.4016 -0.000392101 20.6409 0.0468654 20.8641 0.139069C21.0874 0.231273 21.2903 0.366612 21.4612 0.537339C21.6322 0.708065 21.7677 0.910826 21.8602 1.13401C21.9526 1.3572 22.0001 1.59643 22 1.838V20.16C22.0003 20.4016 21.9529 20.6409 21.8606 20.8642C21.7683 21.0875 21.6328 21.2904 21.462 21.4613C21.2912 21.6322 21.0884 21.7678 20.8651 21.8602C20.6419 21.9526 20.4026 22.0001 20.161 22H1.838C1.59655 22 1.35746 21.9524 1.1344 21.86C0.911335 21.7676 0.708671 21.6321 0.537984 21.4613C0.367297 21.2905 0.231932 21.0878 0.139623 20.8647C0.0473133 20.6416 -0.000131096 20.4025 2.7206e-07 20.161V1.838ZM8.708 8.388H11.687V9.884C12.117 9.024 13.217 8.25 14.87 8.25C18.039 8.25 18.79 9.963 18.79 13.106V18.928H15.583V13.822C15.583 12.032 15.153 11.022 14.061 11.022C12.546 11.022 11.916 12.111 11.916 13.822V18.928H8.708V8.388ZM3.208 18.791H6.416V8.25H3.208V18.79V18.791ZM6.875 4.812C6.88105 5.08667 6.83217 5.35979 6.73124 5.61532C6.63031 5.87084 6.47935 6.10364 6.28723 6.30003C6.09511 6.49643 5.8657 6.65248 5.61246 6.75901C5.35921 6.86554 5.08724 6.92042 4.8125 6.92042C4.53776 6.92042 4.26579 6.86554 4.01255 6.75901C3.7593 6.65248 3.52989 6.49643 3.33777 6.30003C3.14565 6.10364 2.99469 5.87084 2.89376 5.61532C2.79283 5.35979 2.74395 5.08667 2.75 4.812C2.76187 4.27286 2.98439 3.75979 3.36989 3.38269C3.75539 3.00558 4.27322 2.79442 4.8125 2.79442C5.35178 2.79442 5.86961 3.00558 6.25512 3.38269C6.64062 3.75979 6.86313 4.27286 6.875 4.812V4.812Z"
                                          fill="#A1B5D6" />
                                </svg>
                            </a>

                            <a href="https://m.youtube.com/user/EMPESAMostoles" class="ml-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                        <path
                                            d="M23.5 6.50701C23.3641 6.02225 23.0994 5.58336 22.734 5.23702C22.3583 4.88002 21.8978 4.62465 21.396 4.49501C19.518 4.00001 11.994 4.00002 11.994 4.00002C8.85734 3.96433 5.72144 4.12129 2.60401 4.47001C2.1022 4.60923 1.64257 4.8703 1.26601 5.23002C0.896007 5.58602 0.628007 6.02502 0.488007 6.50602C0.1517 8.31776 -0.0117011 10.1574 6.83166e-06 12C-0.0119932 13.841 0.151007 15.68 0.488007 17.494C0.625007 17.973 0.892007 18.41 1.26301 18.763C1.63401 19.116 2.09601 19.371 2.60401 19.506C4.50701 20 11.994 20 11.994 20C15.1347 20.0358 18.2746 19.8788 21.396 19.53C21.8978 19.4004 22.3583 19.145 22.734 18.788C23.104 18.435 23.367 17.996 23.499 17.518C23.8441 15.707 24.0119 13.8666 24 12.023C24.026 10.1716 23.8584 8.32258 23.5 6.50602V6.50701ZM9.60201 15.424V8.57701L15.862 12.001L9.60201 15.424Z"
                                            fill="#A1B5D6" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
