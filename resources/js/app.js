import axios from 'axios';
import './bootstrap';
import 'trix';
import 'trix/dist/trix.css';


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