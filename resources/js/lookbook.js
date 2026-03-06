import { mount } from 'svelte';
import Input from '../../packages/svelte-input/src/lib/Input.svelte';
import ButtonPreview from './ButtonPreview.svelte';

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

// Mount checkbox
mount(Input, {
    target: document.getElementById('preview-checkbox'),
    props: { type: 'checkbox', label: 'Accept terms', id: 'checkbox-example' }
});

// Mount button
mount(ButtonPreview, {
    target: document.getElementById('preview-button')
});
