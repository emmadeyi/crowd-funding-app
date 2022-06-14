<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KingsQuest') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{asset('./vendor/izitoast/css/iziToast.min.css')}}">
        <link rel="stylesheet" href="{{asset('./vendor/toastr/toastr.min.css')}}">
        <link rel="stylesheet" href="{{asset('./vendor/fontawesome/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('./vendor/trix/trix.css')}}">
        <link rel="stylesheet" href="{{asset('./vendor/lightbox/dist/css/lightbox.min.css')}}">
        @livewireStyles
        <style>
            /*Textbox*/
            .ck-editor__editable {
                min-height: 200px;
                max-height: 800px;
                max-width: 860px;
            }
            /*Toolbar*/
            .ck-editor__top {
                max-width: 860px;
            }
        </style>
        <link rel='shortcut icon' type='image/x-icon' href="{{asset('./imgs/logo/logo-black.png')}}" /> 

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <!-- JS Libraies -->
        <script src="{{asset('./vendor/izitoast/js/iziToast.min.js')}}" defer></script>
        <!-- Page Specific JS File -->
        <script src="{{asset('./vendor/toastr/toastr.min.js')}}" defer></script>
        <script src="{{asset('./vendor/fontawesome/js/all.min.js')}}" defer></script>
        <script src="{{asset('./js/custom.js')}}" defer></script>
        @yield('custom-scripts')
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray-100 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 lg:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            <button class=" mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-yellow-400 hover:yellow-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-yellow-400 transition lg:hidden">
                                <svg class="h-4 w-4" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
                <div class="py-12">
                    <div class="max-w-7xl mx-auto lg:px-6 md:px-8">
                        <div class="bg-white overflow-hidden shadow-md lg:rounded-lg">                
                            <div class="relative lg:min-h-screen md:flex">
                                {{-- Sidebar --}}
                                <div class="custom-sidebar bg-gray-100 text-gray-700 w-64 px-2 fixed lg:relative lg:translate-x-0 inset-y-0 left-0 transform -translate-x-full transition duration-200 ease-in-out text-sm ">
                                    
                                    <nav>
                                        <a href="#" class="block py-2.5 px-4 text-right rounded transition duration-200">
                                            <button class="mobile-menu-close-button inline-flex items-center justify-center p-2 rounded-md text-yellow-400 hover:yellow-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-yellow-400 transition lg:hidden object-right-top">
                                                <i class="fa fa-arrow-left"></i>
                                            </button>
                                        </a>
                                        @yield('side-nav')                                        
                                    </nav>
                                </div>
                                {{-- Content --}}
                                <div class="p-10 font-bold flex-1 inset-y-0 ">
                                    @yield('content-div')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/zj9atozi4i5vz69qnmfxkvs8jzb5trcg8u6gwet0iaubg1ln/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="{{ asset('./vendor/lightbox/dist/js/lightbox.min.js') }}"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: 'textarea.tinymce-editor',
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        </script>  
        @yield('custom-scripts')
    </body>
</html>

