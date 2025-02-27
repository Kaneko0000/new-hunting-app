import './bootstrap'; // 既存の Laravel の `bootstrap.js` を読み込む
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Bootstrap の JS を読み込む
import './custom';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
