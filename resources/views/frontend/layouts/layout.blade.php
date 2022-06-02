<!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Bootstrap CSS -->
        <title>@yield("title","bETERNAL")</title>
        @include("frontend.layouts.styles")
    </head>
    <body>   
        <div class="container-fluid h-100">
            <div class="row flex-nowrap h-100">
                <div class="col p-0">
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
    </body>
</html>