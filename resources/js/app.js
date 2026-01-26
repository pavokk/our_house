import axios from 'axios';
import './bootstrap';
import 'trix';
import 'trix/dist/trix.css';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();


window.AppModal = {
    overlay: document.querySelector('#global-modal'),
    titleEl: document.querySelector('#global-modal-title'),
    bodyEl: document.querySelector('#global-modal-body'),
    footerEl: document.querySelector('#global-modal-footer'),

    open({title = '', content = '', actions = [] } = {}) {
        this.titleEl.textContent = title;
        this.bodyEl.innerHTML = content;
        this.footerEl.innerHTML = '';

        if (actions.length > 0) {
            this.footerEl.classList.remove('hidden');
            actions.forEach(btn => {
                const button = document.createElement('button');
                button.textContent = btn.label;
                button.className = btn.class || 'px-4 py-2 bg-gray-200 rounded hover:bg-gray-300';
                button.onclick = btn.onClick || this.close.bind(this);
                this.footerEl.appendChild(button);
            });
        } else {
            this.footerEl.classList.add('hidden');
        }

        this.overlay.classList.remove('hidden');
        setTimeout(() => {
            this.overlay.classList.remove('opacity-0');
            this.overlay.firstElementChild.classList.remove('scale-95'); // Zoom effect
            this.overlay.firstElementChild.classList.add('scale-100');
        }, 10);
    },

    close() {
        // Reverse transitions
        this.overlay.classList.add('opacity-0');
        this.overlay.firstElementChild.classList.remove('scale-100');
        this.overlay.firstElementChild.classList.add('scale-95');

        setTimeout(() => {
            this.overlay.classList.add('hidden');
            this.bodyEl.innerHTML = ''; // Clean up memory/DOM
        }, 200); // Match duration-200 in CSS
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const dropdownBtn = document.getElementById('logoDropdownBtn');
    const dropdownMenu = document.getElementById('logoDropdown');

    dropdownBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
        if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('hidden');
        }
    });

    document.getElementById('global-modal').addEventListener('click', (e) => {
        if (e.target.id === 'global-modal') {
            AppModal.close();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !document.getElementById('global-modal').classList.contains('hidden')) {
            AppModal.close();
        }
    });
});
