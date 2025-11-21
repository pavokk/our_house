import axios from 'axios';
import './bootstrap';
import 'trix';
import 'trix/dist/trix.css';


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
            });
        }
    },
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
});
