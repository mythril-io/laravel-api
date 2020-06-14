<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mythril</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    <a href="https://mythril.io">
                        <img class="block h-8 w-auto" src="https://raw.githubusercontent.com/mythril-io/mythril-ui/master/src/assets/logo.svg?sanitize=true" alt="Mythril.io" />
                    </a>
                </div>

                <div class="links">
                    <a href="https://mythril.io">Website</a>
                    <a href="https://twitter.com/mythril_io">Twitter</a>
                    <a href="https://discord.com/invite/yEbb4B2">Discord</a>
                    <a href="https://www.youtube.com/channel/UCzyb3oKRlLgd9Bf6K7qHEoA">YouTube</a>
                    <a href="https://github.com/mythril-io">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
