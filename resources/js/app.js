import './bootstrap';

let url = window.location.href;

if(url.endsWith('tracking')) {
    let map = L.map('map').setView([14.413447, 121.480293], 18);

    let tile = L.tileLayer(`https://api.mapbox.com/styles/v1/snoopycodex/clir72wpr00ko01r854fsammn/tiles/256/{z}/{x}/{y}@2x?access_token=${import.meta.env.VITE_MAPBOX_ACCESS_TOKEN}`, {
        maxZoom: 19,
        minZoom: 18,
        attribution: '&copy; <a href="http://www.mapbox.com/about/maps">MapBox</a> <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let circle = L.circle([14.413447, 121.480293], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.3,
        weight: 1,
        radius: 60
    }).addTo(map);
}

if(url.endsWith('assign-tour-guide')) {
    if($('#flatpickr-datetime-assign-tour-guide').length) {
        flatpickr("#flatpickr-datetime-assign-tour-guide", {
          wrap: true,
          dateFormat: "Y-m-d \\/ h:i K",
          enableTime: true,
        });
    }
}

if(url.endsWith('add-tourist')) {
    if($('#flatpickr-datetime-add-tourist').length) {
        flatpickr("#flatpickr-datetime-add-tourist", {
          wrap: true,
          dateFormat: "Y-m-d \\/ h:i K",
          enableTime: true,
        });
    }
}
