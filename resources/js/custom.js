document.addEventListener("DOMContentLoaded", function() {
  console.log("カスタムJSが読み込まれました！");

  // 例: すべてのボタンをクリックしたときにアラートを出す
  document.querySelectorAll('.btn').forEach(button => {
      button.addEventListener('click', function() {
          console.log("ボタンがクリックされました！");
      });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".animal-option").forEach(option => {
      option.addEventListener("click", function() {
          // すべての選択肢の選択解除
          document.querySelectorAll(".animal-option").forEach(opt => opt.classList.remove("selected"));

          // クリックされた選択肢をハイライト
          this.classList.add("selected");

          // 選択した動物をフォームにセット
          document.getElementById("selectedAnimal").value = this.dataset.value;
      });
  });
});

// logページ捕獲数選択時
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".count-option").forEach(option => {
      option.addEventListener("click", function() {
          // すべての選択肢の選択解除
          document.querySelectorAll(".count-option").forEach(opt => opt.classList.remove("selected"));

          // クリックされた選択肢をハイライト
          this.classList.add("selected");

          // 選択した数をフォームにセット
          document.getElementById("selectedCount").value = this.dataset.value;
      });
  });
});

// logページ天気選択時
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".weather-option").forEach(option => {
      option.addEventListener("click", function() {
          // すべての選択肢の選択解除
          document.querySelectorAll(".weather-option").forEach(opt => opt.classList.remove("selected"));

          // クリックされた選択肢をハイライト
          this.classList.add("selected");

          // 選択した天気をフォームにセット
          document.getElementById("selectedWeather").value = this.dataset.value;
      });
  });
});

// mapboxのため
mapboxgl.accessToken = 'pk.eyJ1IjoibmFva2lrYW5la28iLCJhIjoiY204Y2wzcWlpMWV3NTJpcWEwaGJwbTloNyJ9.IecMyLEpO8Wp5ihVRHfuQQ'; // ← ここに取得したAPIキーを入れる！

document.addEventListener("DOMContentLoaded", function() {
  if (document.getElementById("log-map")) { // `log-map` のあるページのみ実行
      var map = new mapboxgl.Map({
          container: 'log-map',
          style: 'mapbox://styles/mapbox/streets-v11',
          center: [130.1, 32.5],
          zoom: 10
      });

      var marker = new mapboxgl.Marker({ draggable: true })
          .setLngLat([130.1, 32.5])
          .addTo(map);

      function updateInputFields(lngLat) {
          document.getElementById("longitude").value = lngLat.lng;
          document.getElementById("latitude").value = lngLat.lat;
      }

      marker.on('dragend', function() {
          var lngLat = marker.getLngLat();
          updateInputFields(lngLat);
      });

      // 現在位置取得
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              var lngLat = [position.coords.longitude, position.coords.latitude];
              map.setCenter(lngLat);
              marker.setLngLat(lngLat);
              updateInputFields({ lng: lngLat[0], lat: lngLat[1] });
          });
      }
      var marker = new mapboxgl.Marker({
        draggable: true,
        scale: 1.1 // ← マーカーを1.1倍に
      })
      .setLngLat([130.1, 32.5])
      .addTo(map);

      // 現在地取得ボタンを追加
      var geolocateControl = new mapboxgl.GeolocateControl({
        positionOptions: { enableHighAccuracy: true },
        trackUserLocation: true,
        showUserHeading: true
      });

      map.addControl(geolocateControl, 'top-right');

      // スマホでも地図を操作しやすくする
      map.touchZoomRotate.enable();
      map.scrollZoom.disable(); // PCではスクロール無効
      if (window.innerWidth < 768) {
          map.scrollZoom.enable(); // モバイルならスクロール有効
      }
  }
});
