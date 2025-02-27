document.addEventListener("DOMContentLoaded", function() {
  console.log("カスタムJSが読み込まれました！");

  // 例: すべてのボタンをクリックしたときにアラートを出す
  document.querySelectorAll('.btn').forEach(button => {
      button.addEventListener('click', function() {
          console.log("ボタンがクリックされました！");
      });
  });
});
