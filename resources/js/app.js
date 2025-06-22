import './bootstrap'; // 既存の Laravel の `bootstrap.js` を読み込む
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Bootstrap の JS を読み込む
import Alpine from 'alpinejs';

import { initCustomUI, initFullCalendar } from './custom.js';

window.Alpine = Alpine;
Alpine.start();

console.log("✅ app.js は読み込まれました");

// window.addEventListener('load', () => {
//   console.log("✅ window.load イベント発火しました");
//   initCustomUI();
//   initFullCalendar();
// });
document.addEventListener('DOMContentLoaded', () => {
  console.log("🔥 DOMContentLoaded");
  initCustomUI();       // ✅ custom.js の中で .catch-btn の処理もここでやる
  initFullCalendar();   // カレンダー描画
});