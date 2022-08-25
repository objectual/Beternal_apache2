<!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Bootstrap CSS -->
        <title>@yield("title","bETERNAL")</title>
        @include("frontend.layouts.styles")

        <!-- PWA  -->
        <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
    </head>
    <body>   
        <div class="container-fluid h-100">
            <div class="row flex-nowrap h-100">
                <div class="col p-0 z-9">
                    @include("frontend.layouts.top_head")
                    @include("frontend.layouts.header")
                    @yield("content")
                    @show
                    @include("frontend.layouts.footer_menu")
                    @include("frontend.layouts.footer")
                </div>
            </div>
        </div>
          <!-- Links -->
            @include("frontend.layouts.scripts")

        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function (reg) {
                        console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>
</html>