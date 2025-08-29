<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
  <!-- Use compiled app.css when available, and fall back to the Tailwind CDN for dev / quick fix -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script>
    // If app.css isn't loaded (no stylesheet rules), load Tailwind from CDN as a quick fallback
    (function() {
      var cssLoaded = false;
      try {
        cssLoaded = window.getComputedStyle(document.documentElement).getPropertyValue('--tw-ring-offset-shadow') !== '';
      } catch (e) {}
      if (!cssLoaded) {
        var s = document.createElement('script');
        s.src = 'https://cdn.tailwindcss.com';
        s.defer = true;
        document.head.appendChild(s);
      }
    })();
  </script>
  </head>
    <body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded shadow mx-4">
      <h1 class="text-2xl font-semibold mb-4">Login</h1>
      @if($errors->any())
        <div class="text-red-600 mb-3">{{ $errors->first() }}</div>
      @endif
    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
        @csrf
        <div class="mb-3">
      <label class="block text-sm">Email</label>
      <input name="email" type="email" value="{{ old('email') }}" class="w-full border rounded p-2" />
        </div>
        <div class="mb-3">
      <label class="block text-sm">Password</label>
      <input name="password" type="password" class="w-full border rounded p-2" />
        </div>
        <div class="flex items-center justify-between">
      <button class="px-4 py-2 bg-blue-600 text-white rounded">Login</button>
        </div>
      </form>
    </div>
  </body>
</html>
