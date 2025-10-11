<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Component Lookbook - compoments</title>
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-color-dark: #2563eb;
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
            color: var(--text-color);
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
            color: var(--text-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }

        .component-section p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .preview {
            background: #f9fafb;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 1rem;
        }

        .code-block {
            background: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-top: 1rem;
        }

        .code-block pre {
            margin: 0;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: bold;
            cursor: pointer;
            background-color: var(--primary-color);
            color: white;
            margin: 0.5rem;
        }

        .btn:hover {
            background-color: var(--primary-color-dark);
        }

        .component-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
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

        <!-- Input Component Section -->
        <div class="component-section">
            <h2>Input Component</h2>
            <p>Versatile input component with floating labels and support for various input types.</p>

            <div class="component-grid">
                <div class="variant">
                    <h3>Text Input</h3>
                    <div id="text-input-preview"></div>
                </div>

                <div class="variant">
                    <h3>Email Input</h3>
                    <div id="email-input-preview"></div>
                </div>

                <div class="variant">
                    <h3>Password Input</h3>
                    <div id="password-input-preview"></div>
                </div>

                <div class="variant">
                    <h3>Textarea</h3>
                    <div id="textarea-preview"></div>
                </div>
            </div>

            <div class="code-block">
                <pre>// Example usage
fetch('/input', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        type: 'text',
        label: 'Username',
        placeholder: ' ',
        name: 'username',
        id: 'username'
    })
});</pre>
            </div>
        </div>

        <!-- Modal Component Section -->
        <div class="component-section">
            <h2>Modal Component</h2>
            <p>Customizable modal dialog with multiple size options and smooth animations.</p>

            <div class="preview">
                <button class="btn" onclick="showModalExample('medium')">Modal</button>
            </div>

            <div id="modal-examples"></div>

            <div class="code-block">
                <pre>// Example usage
fetch('/modal', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        title: 'Example Modal',
        content: '&lt;p&gt;This is the modal content.&lt;/p&gt;',
        size: 'medium',
        showCloseButton: true
    })
});</pre>
            </div>
        </div>
    </div>

    <script>
        // Fetch and display input components
        async function loadInputComponent(type, label, containerId) {
            const response = await fetch('/input', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    type: type,
                    label: label,
                    placeholder: ' ',
                    name: type + '_example',
                    id: type + '_example'
                })
            });

            const html = await response.text();
            document.getElementById(containerId).innerHTML = html;
        }

        // Load all input examples
        loadInputComponent('text', 'Username', 'text-input-preview');
        loadInputComponent('email', 'Email Address', 'email-input-preview');
        loadInputComponent('password', 'Password', 'password-input-preview');
        loadInputComponent('textarea', 'Message', 'textarea-preview');

        // Modal example function
        async function showModalExample() {
            const response = await fetch('/modal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    title: `Modal Example`,
                    content: `<p>This is a modal. It demonstrates the modal component.</p><p>Click outside or press the close button to dismiss.</p>`,
                    showCloseButton: true
                })
            });

            const html = await response.text();
            const modalContainer = document.getElementById('modal-examples');
            modalContainer.innerHTML = html;

            // Extract and execute scripts from the inserted HTML
            const scripts = modalContainer.querySelectorAll('script');
            scripts.forEach(script => {
                const newScript = document.createElement('script');
                if (script.src) {
                    newScript.src = script.src;
                } else {
                    newScript.textContent = script.textContent;
                }
                document.body.appendChild(newScript);
                script.remove(); // Remove the non-executing script tag
            });
        }
    </script>
</body>
</html>
