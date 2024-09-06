<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ config('urlshortener.branding.views.protected.content.title') }}</title>
  </head>

  <body class="text-center">
    <main class="form-signin">
      <form action="{{ route('urlshortener.attempt.protected') }}"
            method="POST">
        @csrf
        <input type="hidden"
               name="identifier"
               value="{{ $identifier }}">

        <img class="mb-4"
             src="{{ config('urlshortener.branding.views.protected.images.image-1') }}"
             alt=""
             width="82"
             height="72">
        <h1 class="h3 fw-normal mb-3">Password Protected</h1>

        <div class="form-floating">
          <input id="floatingPassword"
                 type="password"
                 name="password"
                 class="form-control"
                 placeholder="Password">
          <label for="floatingPassword">Password</label>
          @if ($errors)
            @error('password')
              <div class="alert alert-danger">{{ config('urlshortener.branding.views.protected.content.message') }}</div>
            @enderror
          @endif
        </div>
        <button class="w-100 btn btn-lg btn-primary"
                type="submit">Continue</button>
      </form>
    </main>
  </body>

</html>
