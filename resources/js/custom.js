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
            // style: 'mapbox://styles/mapbox/outdoors-v11',
            // style: 'mapbox://styles/mapbox/streets-v11?language=ja',
            style: 'https://tile.openstreetmap.jp/styles/osm-bright-ja/style.json',
            center: [130.1, 32.5], // 天草市
            zoom: 10
        });

        var marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat([130.1, 32.5])
            .addTo(logMap);


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
    

    // 🗺 `/hunters/dashboard` のマップ
    if (document.getElementById("hunter-map")) {
        var hunterMap = new mapboxgl.Map({
            container: 'hunter-map',
            // style: 'mapbox://styles/mapbox/outdoors-v11',
            // style: 'mapbox://styles/mapbox/streets-v11?language=ja',
            style: 'https://tile.openstreetmap.jp/styles/osm-bright-ja/style.json',

            center: [130.1, 32.5], // 初期位置: 天草
            zoom: 10
        });
        
        // ✅ サーバーから埋め込まれた hunterLogs を使う！
        if (typeof hunterLogs !== 'undefined' && hunterLogs.length > 0) {
            hunterLogs.forEach(log => {
                // HTML要素を作成
                const el = document.createElement('div');
                el.className = 'blink-marker';

                // カスタムHTMLマーカーをMapboxに追加
                new mapboxgl.Marker(el)
                    .setLngLat([log.longitude, log.latitude])
                    // .setLngLat([parseFloat(log.longitude), parseFloat(log.latitude)])
                    .setPopup(new mapboxgl.Popup().setText(`${log.animal?.name ?? '不明'} - ${log.capture_date ?? '日付不明'}`))
                    .addTo(hunterMap);
            });
        }

        // スクロール操作の調整
        hunterMap.scrollZoom.disable(); // PCではスクロール無効
        if (window.innerWidth < 768) {
            hunterMap.scrollZoom.enable(); // モバイルならスクロール有効
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.querySelector('.catch-btn');
        btn.addEventListener('click', () => {
            btn.animate([
                { transform: 'scale(1)', offset: 0 },
                { transform: 'scale(1.2)', offset: 0.5 },
                { transform: 'scale(1)', offset: 1 }
            ], {
                duration: 300,
                easing: 'ease-out'
            });
        });
    });

});

document.addEventListener("DOMContentLoaded", function() {
    // 狩猟方法の画像選択
    document.querySelectorAll(".hunting-method-option").forEach(option => {
        option.addEventListener("click", function() {
            // 他の選択肢の選択解除
            document.querySelectorAll(".hunting-method-option").forEach(opt => opt.classList.remove("selected"));

            // クリックされた選択肢をハイライト
            this.classList.add("selected");

            // 選択した狩猟方法名をフォームにセット
            const methodId = parseInt(this.dataset.value, 10);
            document.getElementById("hunting_method_id").value = methodId;
        });
    });
});
