import './bootstrap.js';

// https://stackoverflow.com/questions/64113404/bootstrap-5-referenceerror-bootstrap-is-not-defined
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import './js/scripts.js'; // => error (not in the original template): bootstrap is not defined
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './vendor/bootstrap/dist/css/bootstrap.min.css';
import './styles/styles.css';
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
