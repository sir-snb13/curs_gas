ymaps.ready(init); // Запускаем функцию после загрузки API

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

            var geoObjects = []; // Массив для хранения меток

            data.forEach(station => {
                console.log("Обрабатываем заправку (плохая):", station);

                if (Array.isArray(station.coordinates) && station.coordinates.length === 2) {
                    const [longitude, latitude] = station.coordinates.map(coord => parseFloat(coord));
                    console.log("Преобразованные координаты:", longitude, latitude);

                    if (!isNaN(longitude) && !isNaN(latitude)) {
                        var placemark = new ymaps.Placemark([latitude, longitude], {
                            balloonContentHeader: station.name,
                            balloonContentBody: station.address
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#ff0000' // Красный для плохих заправок
                        });

                        geoObjects.push(placemark); // Добавляем метку в список

                    } else {
                        console.warn("Некорректные координаты:", station.coordinates);
                    }
                } else {
                    console.warn("Заправка без координат или с неверным форматом координат:", station);
                }
            });

            // Добавляем все метки на карту
            geoObjects.forEach(placemark => map.geoObjects.add(placemark));

            // Автоматически центрируем карту и изменяем масштаб, чтобы все метки были видны
            if (geoObjects.length > 0) {
                map.setBounds(map.geoObjects.getBounds(), {
                    checkZoomRange: true
                });
            }

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

            var geoObjects = []; // Массив для хранения меток

            data.forEach(station => {
                console.log("Обрабатываем заправку (хорошая):", station);

                if (Array.isArray(station.coordinates) && station.coordinates.length === 2) {
                    const [longitude, latitude] = station.coordinates.map(coord => parseFloat(coord));
                    console.log("Преобразованные координаты:", longitude, latitude);

                    if (!isNaN(longitude) && !isNaN(latitude)) {
                        var placemark = new ymaps.Placemark([latitude, longitude], {
                            balloonContentHeader: station.name,
                            balloonContentBody: station.address
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#00ff00' // Зеленый для хороших заправок
                        });

                        geoObjects.push(placemark); // Добавляем метку в список

                    } else {
                        console.warn("Некорректные координаты:", station.coordinates);
                    }
                } else {
                    console.warn("Заправка без координат или с неверным форматом координат:", station);
                }
            });

            // Добавляем все метки на карту
            geoObjects.forEach(placemark => map.geoObjects.add(placemark));

            // Автоматически центрируем карту и изменяем масштаб, чтобы все метки были видны
            if (geoObjects.length > 0) {
                map.setBounds(map.geoObjects.getBounds(), {
                    checkZoomRange: true
                });
            }

        })
        .catch(error => console.error('Ошибка загрузки данных (хорошие заправки):', error));
}
