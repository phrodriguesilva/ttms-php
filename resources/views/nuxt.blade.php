<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('_nuxt/entry.css') }}">
    <script type="importmap">
        {
            "imports": {
                "vue": "{{ asset('_nuxt/vue.js') }}",
                "vue-router": "{{ asset('_nuxt/vue-router.js') }}"
            }
        }
    </script>
</head>
<body>
    <div id="__nuxt"></div>
    <script type="module" src="{{ asset('_nuxt/entry.js') }}"></script>
</body>
</html>
