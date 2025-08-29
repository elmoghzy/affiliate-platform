<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','المنصة')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- TikTok Pixel (اختياري) --}}
    @if(config('services.tiktok.pixel_id'))
    <script>
    !function(w,d,t){w.TiktokAnalyticsObject=t;var tt=w[t]=w[t]||[];
    tt.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],
    tt.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat([].slice.call(arguments,0)))}};for(var i=0;i<tt.methods.length;i++)tt.setAndDefer(tt,tt.methods[i]);
    tt.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";tt._i=tt._i||{},tt._i[e]=[],tt._i[e]._u=i,tt._t=tt._t||{},tt._t[e]=+new Date,tt._o=tt._o||{},tt._o[e]=n||{};
    var s=d.createElement("script");s.type="text/javascript",s.async=!0,s.src=i+"?sdkid="+e+"&lib="+t;var a=d.getElementsByTagName("script")[0];a.parentNode.insertBefore(s,a)};
    tt.load("{{ config('services.tiktok.pixel_id') }}"); tt.page();
    }(window,document,'ttq');
    </script>
    @endif

    {{-- 👇 مهم لحقن التاجز الديناميكية من الصفحات --}}
    @stack('head')
    <style>html{scroll-behavior:smooth}</style>
</head>
<body class="bg-gray-900 text-gray-100 font-sans leading-relaxed">
    <div class="min-h-screen flex flex-col">
        <header class="bg-gray-800 border-b border-gray-700">
            <div class="container mx-auto px-4 py-4 flex items-center justify-between">
                <a href="/" class="text-xl font-semibold">{{ config('app.name', 'Affiliate Platform') }}</a>
            </div>
        </header>

        <main class="flex-1 container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <footer class="bg-gray-800 border-t border-gray-700">
            <div class="container mx-auto px-4 py-4 text-sm text-gray-400 text-center">&copy; {{ date('Y') }} {{ config('app.name') }}</div>
        </footer>
    </div>
</body>
</html>
