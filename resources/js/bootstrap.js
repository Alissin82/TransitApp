import axios from 'axios';
import '@material/web/all.js';
import {styles as typescaleStyles} from '@material/web/typography/md-typescale-styles.js';

import toastr from 'toastr';

window.axios = axios;
window.toastr = toastr;

document.adoptedStyleSheets.push(typescaleStyles.styleSheet);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
