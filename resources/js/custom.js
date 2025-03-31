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
            document.getElementById("animal_id").value = this.dataset.value;
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
            document.getElementById("count").value = this.dataset.value;
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
            document.getElementById("weather_id").value = this.dataset.value;
        });
    });
});

// mapboxのため
mapboxgl.accessToken = 'pk.eyJ1IjoibmFva2lrYW5la28iLCJhIjoiY204Y2wzcWlpMWV3NTJpcWEwaGJwbTloNyJ9.IecMyLEpO8Wp5ihVRHfuQQ'; // ← ここに取得したAPIキーを入れる！

document.addEventListener("DOMContentLoaded", function() {
    console.log("カスタムJSが読み込まれました！");

    if (document.getElementById("log-map")) {
        var logMap = new mapboxgl.Map({
            container: 'log-map',
            style: 'mapbox://styles/mapbox/outdoors-v11',
            center: [130.1, 32.5], // 天草市
            zoom: 10
        });

        var marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat([130.1, 32.5])
            .addTo(logMap);

        // 🎯 位置情報を `input` にセットする関数
        function updateInputFields(lngLat) {
            document.getElementById("latitude").value = lngLat.lat;
            document.getElementById("longitude").value = lngLat.lng;

            // 🌍 逆ジオコーディング（座標 → 住所）
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lngLat.lng},${lngLat.lat}.json?language=ja&access_token=${mapboxgl.accessToken}`)
                .then(response => response.json())
                .then(data => {
                    if (data.features.length > 0) {
                        let fullPlace = data.features[0].place_name;
                        let trimmedPlace = fullPlace.replace(/^日本\s?/, ''); // "日本" を先頭から削除
                        document.getElementById("location").value = trimmedPlace;
                    }
                })
                .catch(error => console.error("逆ジオコーディングエラー:", error));
        }

        // 🎯 マーカーを動かしたときの処理
        marker.on('dragend', function() {
            var lngLat = marker.getLngLat();
            updateInputFields(lngLat);
        });

        // 🎯 初回ページ表示時に現在位置を取得（ユーザー許可時）
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lngLat = [position.coords.longitude, position.coords.latitude];
                    logMap.setCenter(lngLat);
                    marker.setLngLat(lngLat);
                    updateInputFields({ lat: lngLat[1], lng: lngLat[0] });
                },
                function(error) {
                    console.error("位置情報取得エラー:", error);
                },
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        }

        // 🎯 現在地取得ボタンを追加
        var geolocateControl = new mapboxgl.GeolocateControl({
            positionOptions: { enableHighAccuracy: true },
            trackUserLocation: true,
            showUserHeading: true
        });

        logMap.addControl(geolocateControl, 'top-right');
    }

    // 🗺 `/hunters/dashboard` のマップ
    if (document.getElementById("hunter-map")) {
        var hunterMap = new mapboxgl.Map({
            container: 'hunter-map',
            style: 'mapbox://styles/mapbox/outdoors-v11',
            center: [130.1, 32.5], // 初期位置: 天草
            zoom: 10
        });

        // LaravelのAPIから捕獲データを取得し、マーカーを追加
        fetch('/api/hunter-logs')
            .then(response => response.json())
            .then(data => {
                data.forEach(log => {
                    new mapboxgl.Marker()
                        .setLngLat([log.longitude, log.latitude])
                        .setPopup(new mapboxgl.Popup().setText(`${log.animal} - ${log.date}`))
                        .addTo(hunterMap);
                });
            });

        // スクロール操作の調整
        hunterMap.scrollZoom.disable(); // PCではスクロール無効
        if (window.innerWidth < 768) {
            hunterMap.scrollZoom.enable(); // モバイルならスクロール有効
        }
    }

//   function showSection(section) {
//     const sections = ['capture', 'board', 'map', 'message'];
//     sections.forEach(id => {
//         document.getElementById(`section-${id}`).classList.add('d-none');
//     });
//     document.getElementById(`section-${section}`).classList.remove('d-none');
// }

});
