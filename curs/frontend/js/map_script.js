ymaps.ready(init);

let badStationsGeoObjects = [];
let goodStationsGeoObjects = [];

function init() {
    var map = new ymaps.Map("map", {
        center: [55.751244, 37.618423], // Центр Москвы
        zoom: 10
    });

    // Функция для загрузки заправок с фильтрацией по округу
    function loadStations(district) {
        // Загружаем данные для плохих заправок с учетом округа
        fetch(`/curs/backend/api/get_bad_stations.php?district=${district}`)
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

                            badStationsGeoObjects.push(placemark);
                        }
                    }
                });

                updateMap();
            })
            .catch(error => console.error('Ошибка загрузки данных (плохие заправки):', error));

        // Загружаем данные для хороших заправок с учетом округа
        fetch(`/curs/backend/api/get_good_stations.php?district=${district}`)
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

                            goodStationsGeoObjects.push(placemark);
                        }
                    }
                });

                updateMap();
            })
            .catch(error => console.error('Ошибка загрузки данных (хорошие заправки):', error));
    }

    // Загружаем данные для всех заправок при первой загрузке страницы
    loadStations('all');

    // Функция для обновления карты в зависимости от состояния фильтров
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

    // Обработчики событий для чекбоксов
    document.getElementById("showBadStations").addEventListener("change", updateMap);
    document.getElementById("showGoodStations").addEventListener("change", updateMap);

    // Обработчик события для выбора округа
    document.getElementById("district-select").addEventListener("change", function() {
        const selectedDistrict = this.value;
        loadStations(selectedDistrict);
    });
}
