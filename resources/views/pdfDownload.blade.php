<html>

<head>
    <style>
        @font-face {
            font-family: roboto;
            src: url({{ asset('fonts/Roboto-Regular.ttf') }})
        }

        /** Define the margins of your page **/
        @page {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans';
            margin-left: 75.6px;
            margin-top: 37.8px;
            margin-right: 75.6px
        }

        .bottom__right {
            position: absolute;
            bottom: 0px;
            right: 0px;
        }

        .bottom__left {
            position: absolute;
            bottom: 0px;
            left: 0px;
        }

        .bottom__left p {
            margin-top: -12px;
        }
    </style>
</head>

<body>
    <header>
        <div class="top__left">
            <img src="{{ asset('Orqa-mail-logo.png') }}" width="102.72px" height="82.56px" />
            <div>
    </header>

    <footer>
        <div class="bottom__left">
            <p style="font-weight: 700;font-size:17px">Orqa d.o.o</p>
            <p style="font-size:14px;">J.J.Strossmayera 341</p>
            <p style="font-size:14px;">Osijek, Croatia</p>
            <p style="font-weight:700;font-size:14px;">www.orqafpv.com</p>
        </div>
        <div class="bottom__right">
            <img src="{{ asset('Orqa-mail-logo-small.png') }}" width="60.48px" height="50px" />
        </div>

    </footer>

    <main>

    </main>
</body>

</html>
