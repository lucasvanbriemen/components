import FileManager from './components/FileManager.svelte';
import { mount } from 'svelte';

mount(FileManager, {
    target: document.getElementById('file-manager'),
});
