ymaps.ready(init);

let badStationsGeoObjects = [];
let goodStationsGeoObjects = [];

function init() {
    var map = new ymaps.Map("map", {
        center: [55.751244, 37.618423],
        zoom: 10
    });

    function loadStations(district) {
        fetch(`/curs/backend/api/get_user_bad_stations.php?district=${district}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Данные с сервера (плохие заправки):", data);

                badStationsGeoObjects = [];

                data.forEach(station => {
                    if (Array.isArray(station.coordinates) && station.coordinates.length === 2) {
                        const [longitude, latitude] = station.coordinates.map(coord => parseFloat(coord));

                        if (!isNaN(longitude) && !isNaN(latitude)) {
                            var placemark = new ymaps.Placemark([latitude, longitude], {
                                balloonContentHeader: station.name,
                                balloonContentBody: `
                                    <b>Адрес:</b> ${station.address}<br>
                                    <b>Нарушения:</b> ${station.violations || 'Нет данных'}
                                `
                            }, {
                                preset: 'islands#icon',
                                iconColor: '#ff0000'
                            });

                            badStationsGeoObjects.push(placemark);
                        }
                    }
                });

                updateMap();
            })
            .catch(error => console.error('Ошибка загрузки данных (плохие заправки):', error));

        fetch(`/curs/backend/api/get_user_good_stations.php?district=${district}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Данные с сервера (хорошие заправки):", data);

                goodStationsGeoObjects = [];

                data.forEach(station => {
                    if (Array.isArray(station.coordinates) && station.coordinates.length === 2) {
                        const [longitude, latitude] = station.coordinates.map(coord => parseFloat(coord));

                        if (!isNaN(longitude) && !isNaN(latitude)) {
                            var placemark = new ymaps.Placemark([latitude, longitude], {
                                balloonContentHeader: station.name,
                                balloonContentBody: `
                                    <b>Адрес:</b> ${station.address}
                                `
                            }, {
                                preset: 'islands#icon',
                                iconColor: '#00ff00' 
                            });

                            goodStationsGeoObjects.push(placemark);
                        }
                    }
                });

                updateMap();
            })
            .catch(error => console.error('Ошибка загрузки данных (хорошие заправки):', error));
    }

    loadStations('all');

    function updateMap() {
        map.geoObjects.removeAll();

        if (document.getElementById("showBadStations").checked) {
            badStationsGeoObjects.forEach(placemark => map.geoObjects.add(placemark));
        }
        if (document.getElementById("showGoodStations").checked) {
            goodStationsGeoObjects.forEach(placemark => map.geoObjects.add(placemark));
        }

        if (map.geoObjects.getLength() > 0) {
            map.setBounds(map.geoObjects.getBounds(), {
                checkZoomRange: true
            });
        }
    }

    document.getElementById("showBadStations").addEventListener("change", updateMap);
    document.getElementById("showGoodStations").addEventListener("change", updateMap);
    document.getElementById("district-select").addEventListener("change", function() {
        const selectedDistrict = this.value;
        loadStations(selectedDistrict);
    });
}
