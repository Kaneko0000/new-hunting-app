// FullCalendar 関連
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import jaLocale from '@fullcalendar/core/locales/ja';
// mapbox関連
// import mapboxgl from 'mapbox-gl';

export function initFullCalendar() {
    const calendarEl = document.getElementById("hunter-calendar");
    if (!calendarEl || typeof window.calendarEvents === 'undefined') {
        console.warn("📅 calendarEvents が未定義 or 要素なし");
        return;
    }

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        locale: jaLocale,
        height: 600,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        events: window.calendarEvents,
        eventDisplay: 'block',
        eventBackgroundColor: 'transparent',
        eventBorderColor: 'transparent',
        // ✅ タイトルを使わず画像だけ描画する
        eventContent: function(arg) {
            const iconPath = arg.event.extendedProps.icon;
            const count = arg.event.extendedProps.count ?? 1;
        
            if (!iconPath) return;
        
            const container = document.createElement('div');
        
            for (let i = 0; i < count; i++) {
                const img = document.createElement('img');
                img.src = iconPath;
                img.alt = 'animal';
                // img.title = `${count}頭捕獲`;
                img.style.width = '20px';
                img.style.height = '20px';
                img.style.marginRight = '2px';
                container.appendChild(img);
            }
        
            return { domNodes: [container] };
        },

        eventClick: function(info) {
            const date = info.event.startStr;
            window.location.href = `/hunters/logs?date=${date}`;
        }
        
    });

    calendar.render();
}


export function initCustomUI() {

    console.log("✅ initCustomUI 開始");

    // ✅ ヒーロー画像のローテーション処理
    const heroSection = document.querySelector(".hero-section");
    if (heroSection) {
        const heroImages = [
            "/images/top_1.jpg",
            "/images/top_6.jpg",
            "/images/top_5.jpg"
        ];
        let currentHeroIndex = 0;
    
        const changeHeroBackground = () => {
            currentHeroIndex = (currentHeroIndex + 1) % heroImages.length;
    
            // 1. ズームリセット
            heroSection.classList.remove("zooming");
            void heroSection.offsetWidth;
    
            // 2. 背景切り替え
            heroSection.style.backgroundImage = `url('${heroImages[currentHeroIndex]}')`;
    
            // 3. ズーム再適用
            heroSection.classList.add("zooming");
        };
    
        // 初期画像＋アニメ適用
        heroSection.style.backgroundImage = `url('${heroImages[0]}')`;
        heroSection.classList.add("fade-transition", "zooming");
    
        // 切り替えを実行
        setInterval(changeHeroBackground, 5000);
    }
    
    


    const btn = document.getElementById('capture-button');
    const flash = document.getElementById('capture-flash');
    console.log("btnは？", btn);
    console.log("flashは？", flash);

    if (btn && flash) {
        console.log("🟢 捕まえたボタンイベント登録");

        btn.addEventListener('click', (e) => {
            e.preventDefault();

            flash.classList.remove("animate");
            void flash.offsetWidth;
            flash.classList.add("animate");

            setTimeout(() => {
                flash.classList.remove("animate");
                location.href = btn.dataset.url || "/hunters/log";
            }, 1500);
        });
    } else if (btn || flash){
        console.log("btnかflashある");
    } else {
        console.warn("❌ capture-button または capture-flash が見つかりません");
    }

    // 例: すべてのボタンをクリックしたときにアラートを出す
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            console.log("ボタンがクリックされました！");
        });
    });

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

    // logページ捕獲数選択時
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

    // logページ天気選択時
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
    
    // CDN方式で動かす場合
    window.mapboxgl.accessToken = window.mapboxToken;

    if (document.getElementById("log-map")) {
        const logMap = new window.mapboxgl.Map({
            container: 'log-map',
            style: 'https://tile.openstreetmap.jp/styles/osm-bright-ja/style.json',
            center: [130.1, 32.5],
            zoom: 10
        });

        const marker = new window.mapboxgl.Marker({ draggable: true })
            .setLngLat([130.1, 32.5])
            .addTo(logMap);

        marker.on('dragend', function() {
            const lngLat = marker.getLngLat();
            updateInputFields(lngLat);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lngLat = [position.coords.longitude, position.coords.latitude];
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

        const geolocateControl = new window.mapboxgl.GeolocateControl({
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
        var hunterMap = new window.mapboxgl.Map({
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
                new window.mapboxgl.Marker(el)
                    .setLngLat([log.longitude, log.latitude])
                    // .setLngLat([parseFloat(log.longitude), parseFloat(log.latitude)])
                    .setPopup(new window.mapboxgl.Popup().setText(`${log.animal?.name ?? '不明'} - ${log.capture_date ?? '日付不明'}`))
                    .addTo(hunterMap);
            });
        }
    
        // スクロール操作の調整
        hunterMap.scrollZoom.disable(); // PCではスクロール無効
        if (window.innerWidth < 768) {
            hunterMap.scrollZoom.enable(); // モバイルならスクロール有効
        }
    }

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

    // 編集モードなどで既に値が入っている場合、対応するUIに .selected を付ける
    function setInitialSelections() {
        const selectedAnimalId = document.getElementById("animal_id")?.value;
        if (selectedAnimalId) {
            document.querySelectorAll(".animal-option").forEach(el => {
                if (el.dataset.value === selectedAnimalId) {
                    el.classList.add("selected");
                }
            });
        }

        const selectedCount = document.getElementById("count")?.value;
        if (selectedCount) {
            document.querySelectorAll(".count-option").forEach(el => {
                if (el.dataset.value === selectedCount) {
                    el.classList.add("selected");
                }
            });
        }

        const selectedWeather = document.getElementById("weather_id")?.value;
        if (selectedWeather) {
            document.querySelectorAll(".weather-option").forEach(el => {
                if (el.dataset.value === selectedWeather) {
                    el.classList.add("selected");
                }
            });
        }

        const selectedMethod = document.getElementById("hunting_method_id")?.value;
        if (selectedMethod) {
            document.querySelectorAll(".hunting-method-option").forEach(el => {
                if (el.dataset.value === selectedMethod) {
                    el.classList.add("selected");
                }
            });
        }
    }

    // 最後に呼び出し
    setInitialSelections();

}
