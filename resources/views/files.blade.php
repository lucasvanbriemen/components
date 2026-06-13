<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Manager - compoments</title>
    @vite(['resources/js/files.js'])
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-color-dark: #4f46e5;
            --background-color-one: #ffffff;
            --text-color: #1f2937;
            --border-color: #d1d5db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f9fafb;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 3rem;
            font-size: 1.125rem;
        }

        .component-section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .component-section h2 {
            font-size: 1.875rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }

        .component-section > p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File Manager</h1>
        <p class="subtitle">Upload, browse, download and delete files</p>

        <div class="component-section">
            <h2>Files</h2>
            <p>Anyone can browse and download. Uploading and deleting require a valid login session.</p>

            <div id="file-manager"></div>
        </div>
    </div>
</body>
</html>
