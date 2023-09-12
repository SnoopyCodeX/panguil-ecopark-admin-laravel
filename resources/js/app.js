import Pubnub from 'pubnub';
import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const ecoParkLtLng = [14.413447, 121.480293];
    let userLocations = JSON.parse(window.sessionStorage.getItem('user-locations')) ?? {};
    let url = window.location.href;
    let markers = {};
    let map = undefined;

    let pubnub = new Pubnub({
        publishKey: `${import.meta.env.VITE_PUBNUB_PUBLISH_KEY}`,
        subscribeKey: `${import.meta.env.VITE_PUBNUB_SUBSCRIBE_KEY}`,
        secretKey: `${import.meta.env.VITE_PUBNUB_SECRET_KEY}`,
        userId: `${user.name}-${user.id}`,
    });

    let listener = {
        status: (statusEvent) => {
            if(statusEvent.category === 'PNConnectedCategory') {
                console.log('Pubnub connection established!');
            }
        },
        message: (messageEvent) => {
            let messageContent = messageEvent.message;
            let message = JSON.parse(messageContent);

            // If the message type is not a location, ignore it.
            if(message.type != 'location') return;

            let locationData = message.data;
            userLocations[locationData.id] = {name: locationData.name, latitude: locationData.latitude, longitude: locationData.longitude};
            updateUserLocationsInLS(userLocations);

            if(url.endsWith('tracking'))
                updateMarker(locationData.id, {name: locationData.name, latitude: locationData.latitude, longitude: locationData.longitude});
        }
    };

    pubnub.addListener(listener);
    pubnub.subscribe({
        channels: [`${import.meta.env.VITE_PUBNUB_CHANNEL_NAME}`]
    });

    let updateMap = () => {
        for(let id in userLocations)
            updateMarker(id, userLocations[id]);
    };

    let updateMarker = (id, data) => {
        let { latitude, longitude, name } = data;
        let distanceFromCenter = map.distance(ecoParkLtLng, [latitude, longitude]).toFixed(2);

        if(markers[id] === undefined)
            markers[id] = L.marker([latitude, longitude], {title: name}).addTo(map);
        else
            markers[id].setLatLng([latitude, longitude]).update();

        markers[id].bindPopup(`<strong>Name:</strong> ${name}<br/><strong>Distance:</strong> ${distanceFromCenter}m away`).update();
    };

    let updateUserLocationsInLS = (newUserLocations) => window.sessionStorage.setItem('user-locations', JSON.stringify(newUserLocations));

    if(url.endsWith('tracking')) {
        map = L.map('map').setView(ecoParkLtLng, 18);

        let tile = L.tileLayer(`https://api.mapbox.com/styles/v1/snoopycodex/clir72wpr00ko01r854fsammn/tiles/256/{z}/{x}/{y}@2x?access_token=${import.meta.env.VITE_MAPBOX_ACCESS_TOKEN}`, {
            maxZoom: 19,
            minZoom: 18,
            attribution: '&copy; <a href="http://www.mapbox.com/about/maps">MapBox</a> <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let circle = L.circle(ecoParkLtLng, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.3,
            weight: 1,
            radius: 60
        }).addTo(map);

        updateMap();
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

    if(url.endsWith('reservations')) {
        if($('#flatpickr-datetime-assign-reservation').length) {
            flatpickr("#flatpickr-datetime-assign-reservation", {
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
});
