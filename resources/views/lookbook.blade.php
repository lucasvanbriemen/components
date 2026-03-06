<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Component Lookbook - compoments</title>
    @vite(['resources/js/lookbook.js'])
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

        .component-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .variant {
            background: #f9fafb;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
        }

        .variant h3 {
            font-size: 1.125rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Component Lookbook</h1>
        <p class="subtitle">A showcase of all available components in the compoments library</p>

        <div class="component-section">
            <h2>Input Component</h2>
            <p>Versatile input component with floating labels and support for various input types.</p>

            <div class="component-grid">
                <div class="variant">
                    <h3>Text Input</h3>
                    <div id="preview-text"></div>
                </div>

                <div class="variant">
                    <h3>Email Input</h3>
                    <div id="preview-email"></div>
                </div>

                <div class="variant">
                    <h3>Password Input</h3>
                    <div id="preview-password"></div>
                </div>

                <div class="variant">
                    <h3>Textarea</h3>
                    <div id="preview-textarea"></div>
                </div>
            </div>
        </div>

        <div class="component-section">
            <h2>Button Component</h2>
            <p>Customizable button component with variant support.</p>

            <div class="component-grid">
                <div class="variant">
                    <h3>Call to Action</h3>
                    <div id="preview-button"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
