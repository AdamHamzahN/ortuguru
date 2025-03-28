import './bootstrap';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import Swal from 'sweetalert2';
window.swal = Swal;

import DataTable from 'datatables.net-bs5';
window.datatable = DataTable;

import Buttons from 'datatables.net-buttons-dt';
window.Buttons = Buttons;

import  select2 from 'select2';
select2();