<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lookbook • {{ $component['name'] }}</title>
  <style>
    body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, sans-serif; padding: 2rem; color: #111827; }
    a { color: #2563eb; text-decoration: none; }
    a:hover { text-decoration: underline; }
    header { display: flex; align-items: baseline; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; }
    h1 { font-size: 1.5rem; margin: 0; }
    .btn { display: inline-block; padding: .375rem .625rem; border: 1px solid #e5e7eb; border-radius: .375rem; background: #fff; color: inherit; text-decoration: none; }
    .grid { display: grid; grid-template-columns: 1fr; gap: 1rem; }
    @media (min-width: 1024px) { .grid { grid-template-columns: 1fr 1fr; } }
    .panel { border: 1px solid #e5e7eb; border-radius: .5rem; background: #fff; overflow: hidden; }
    .panel h2 { font-size: 1rem; margin: 0; padding: .5rem .75rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
    .preview { padding: 1rem; }
    .code { position: relative; }
    pre { margin: 0; padding: .75rem 1rem; overflow: auto; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; font-size: .85rem; background: #0b1020; color: #e5e7eb; }
    .copy { position: absolute; top: .5rem; right: .5rem; }
    .stack { display: grid; gap: 1rem; }
  </style>
  <script>
    function copyText(text) { navigator.clipboard && navigator.clipboard.writeText(text); }
  </script>
</head>
<body>
  <header>
    <h1>{{ $component['name'] }}</h1>
    <a class="btn" href="{{ url('/lookbook') }}">Back to Lookbook</a>
  </header>

  <div class="grid">
    <section class="panel">
      <h2>Preview</h2>
      <div class="preview">
        @includeIf('components.' . $component['name'])
      </div>
    </section>

    <section class="panel code">
      <h2>View (Blade)</h2>
      <button class="btn copy" onclick='copyText(@json($component["view"]))'>Copy</button>
      <pre><code>{{ $component['view'] }}</code></pre>
    </section>

    <section class="panel code">
      <h2>SCSS</h2>
      <button class="btn copy" onclick='copyText(@json($component["scss"]))'>Copy</button>
      <pre><code>{{ $component['scss'] }}</code></pre>
    </section>

    <section class="panel code">
      <h2>JS</h2>
      <button class="btn copy" onclick='copyText(@json($component["js"]))'>Copy</button>
      <pre><code>{{ $component['js'] }}</code></pre>
    </section>
  </div>

  <script>
    // Inline the component JS so preview is interactive
    {!! $component['js'] !!}
  </script>
</body>
</html>

