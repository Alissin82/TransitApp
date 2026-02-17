import axios from 'axios';
import * as mdb from 'mdb-ui-kit';
import { initMDB } from 'mdb-ui-kit';

window.axios = axios;

// TODO: consider tree-shaking later to improve performance
initMDB(mdb);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
