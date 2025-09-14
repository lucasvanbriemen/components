<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lookbook</title>
  <style>
    body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, sans-serif; padding: 2rem; }
    h1 { font-size: 1.5rem; margin-bottom: 1rem; }
    ul { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: .75rem; padding: 0; }
    li { list-style: none; }
    a { display: block; padding: .75rem 1rem; border: 1px solid #e5e7eb; border-radius: .5rem; text-decoration: none; color: inherit; }
    a:hover { background: #f9fafb; }
    .empty { color: #6b7280; font-size: .95rem; }
  </style>
  </head>
<body>
  <h1>Lookbook</h1>
  @if (empty($components))
    <p class="empty">No components found in <code>resources/views/components</code>.</p>
  @else
    <ul>
      @foreach ($components as $name)
        <li><a href="{{ url('/lookbook/'.$name) }}">{{ $name }}</a></li>
      @endforeach
    </ul>
  @endif
</body>
</html>

