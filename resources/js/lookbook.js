import Input from '../../packages/svelte-input/src/lib/Input.svelte';
import { mount } from 'svelte';

// Mount text input
mount(Input, {
    target: document.getElementById('preview-text'),
    props: { type: 'text', label: 'Username', id: 'text-example', placeholder: ' ' }
});

// Mount email input
mount(Input, {
    target: document.getElementById('preview-email'),
    props: { type: 'email', label: 'Email Address', id: 'email-example', placeholder: ' ' }
});

// Mount password input
mount(Input, {
    target: document.getElementById('preview-password'),
    props: { type: 'password', label: 'Password', id: 'password-example', placeholder: ' ' }
});

// Mount textarea
mount(Input, {
    target: document.getElementById('preview-textarea'),
    props: { type: 'textarea', label: 'Message', id: 'textarea-example', placeholder: ' ' }
});
