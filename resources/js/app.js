import './bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

// Bootstrap Icons
import 'bootstrap-icons/font/bootstrap-icons.css';

// Custom JS files
import './guest';
import './dashboard';
import './header';
import './profile';

axios.defaults.headers.common['X-Auth-Token'] =
    sessionStorage.getItem('auth_token');


