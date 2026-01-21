import $ from 'jquery';

// 🔥 expose FIRST
window.$ = window.jQuery = $;

// Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;


// DataTables (AFTER jQuery)
import 'datatables.net';
import 'datatables.net-bs5';

import Swal from 'sweetalert2';
window.Swal = Swal;

// Alpine (last)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import '@fortawesome/fontawesome-free/css/all.css';


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
});