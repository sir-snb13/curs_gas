ymaps.ready(init);

let badStationsGeoObjects = [];
let goodStationsGeoObjects = [];

function init() {
    var map = new ymaps.Map("map", {
        center: [55.751244, 37.618423], // Центр Москвы
        zoom: 10
    });

    // Загружаем данные для плохих заправок
    fetch('/curs/backend/api/get_bad_stations.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Данные с сервера (плохие заправки):", data);

            // Очищаем массив плохих заправок
            badStationsGeoObjects = [];

            data.forEach(station => {
                if (Array.isArray(station.coordinates) && station.coordinates.length === 2) {
                    const [longitude, latitude] = station.coordinates.map(coord => parseFloat(coord));

                    if (!isNaN(longitude) && !isNaN(latitude)) {
                        var placemark = new ymaps.Placemark([latitude, longitude], {
                            balloonContentHeader: station.name,
                            balloonContentBody: station.address
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#ff0000' // Красный для плохих заправок
                        });

                        badStationsGeoObjects.push(placemark); // Добавляем метку в список плохих заправок
                    }
                }
            });

            updateMap(); // Обновляем карту в соответствии с выбранными фильтрами
        })
        .catch(error => console.error('Ошибка загрузки данных (плохие заправки):', error));

    // Загружаем данные для хороших заправок
    fetch('/curs/backend/api/get_good_stations.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Данные с сервера (хорошие заправки):", data);

            // Очищаем массив хороших заправок
            goodStationsGeoObjects = [];

            data.forEach(station => {
                if (Array.isArray(station.coordinates) && station.coordinates.length === 2) {
                    const [longitude, latitude] = station.coordinates.map(coord => parseFloat(coord));

                    if (!isNaN(longitude) && !isNaN(latitude)) {
                        var placemark = new ymaps.Placemark([latitude, longitude], {
                            balloonContentHeader: station.name,
                            balloonContentBody: station.address
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#00ff00' // Зеленый для хороших заправок
                        });

                        goodStationsGeoObjects.push(placemark); // Добавляем метку в список хороших заправок
                    }
                }
            });

            updateMap(); // Обновляем карту в соответствии с выбранными фильтрами
        })
        .catch(error => console.error('Ошибка загрузки данных (хорошие заправки):', error));

    // Функция для обновления карты в зависимости от состояния чекбоксов
    function updateMap() {
        // Сначала очищаем карту
        map.geoObjects.removeAll();

        // Добавляем только выбранные метки
        if (document.getElementById("showBadStations").checked) {
            badStationsGeoObjects.forEach(placemark => map.geoObjects.add(placemark));
        }
        if (document.getElementById("showGoodStations").checked) {
            goodStationsGeoObjects.forEach(placemark => map.geoObjects.add(placemark));
        }

        // Автоматически центрируем карту и изменяем масштаб, чтобы все метки были видны
        if (map.geoObjects.getLength() > 0) {
            map.setBounds(map.geoObjects.getBounds(), {
                checkZoomRange: true
            });
        }
    }

    // Обработчики событий для чекбоксов, чтобы обновить карту при изменении фильтров
    document.getElementById("showBadStations").addEventListener("change", updateMap);
    document.getElementById("showGoodStations").addEventListener("change", updateMap);
}
