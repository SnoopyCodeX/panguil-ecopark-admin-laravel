import Pubnub from 'pubnub';

import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const ecoParkLtLng = [14.413447, 121.480293];
    let userLocations = JSON.parse(window.sessionStorage.getItem('user-locations')) ?? {};
    let url = window.location.href;
    let layerGroup;

    // let undoLayersStack = [];
    // let redoLayersStack = [];

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
            markers[id] = L.marker([latitude, longitude], {title: name, pmIgnore: true}).addTo(map);
        else
            markers[id].setLatLng([latitude, longitude]).update();

        markers[id].bindPopup(`<strong>Name:</strong> ${name}<br/><strong>Distance:</strong> ${distanceFromCenter}m away`).update();
    };

    let updateUserLocationsInLS = (newUserLocations) => window.sessionStorage.setItem('user-locations', JSON.stringify(newUserLocations));

    let showSuccessToast = (message) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            timer: 3000,
            iconColor: 'white',
            timerProgressBar: true,
            showConfirmButton: false,
            customClass: {
                popup: 'colored-toast'
            }
        });
        Toast.fire({
            icon: 'success',
            title: message
        });
    };

    let showErrorToast = (message) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            timer: 3000,
            iconColor: 'white',
            timerProgressBar: true,
            showConfirmButton: false,
            customClass: {
                popup: 'colored-toast'
            }
        });
        Toast.fire({
            icon: 'error',
            title: message
        });
    };

    let saveGeofence = (geojson) => {
        let data = JSON.stringify(geojson);

        $.post(saveGeofenceURL, {geojson: data})
            .done(function(data) {
                console.log('save success', data);
                showSuccessToast("Geofence created successfully!");
            })
            .fail(function(data) {
                console.log('save failed');
                showErrorToast("Oops, something went wrong while saving the geofence to the database");
            });

        initMapGeofences(map, {reInit: true});
    }

    let updateGeofence = (id, geojson) => {
        let data = JSON.stringify(geojson);

        $.post(updateGeofenceURL.replace('{id}', id), {geojson: data})
            .done(function(data) {
                console.log('update success');
                showSuccessToast("Geofence was updated successfully!");
            })
            .fail(function(data) {
                console.log('update failed');
                showErrorToast("Oops, failed to update the geofence on the database");
            });

        initMapGeofences(map, {reInit: true});
    };

    let removeGeofence = (id) => {
        $.post(deleteGeofenceURL.replace('{id}', id))
            .done(function(data) {
                console.log('remove success');
                showSuccessToast("Geofence was removed successfully!");
            })
            .fail(function(data) {
                console.log('remove failed');

                initMapGeofences(map, {reInit: true});
                showErrorToast("Oops, failed to remove the geofence on the database");
            });
    };

    let eventUpdatedLayer = (pmUpdateEvent, id) => {
        Swal.fire({
            title: 'Confirm Changes',
            text: 'Do you really want to update this geofence?',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Update',
            reverseButtons: true
        }).then((result) => {
            if(result.isConfirmed) {
                let geomanLayers = map.pm.getGeomanDrawLayers();
                geomanLayers.forEach((geomanLayer) => map.removeLayer(geomanLayer));

                // If the layer's shape is a cirlce, create a new representation of it
                // since GeoJSON doesn't have a spec for circles
                if(pmUpdateEvent.shape.toLowerCase() == 'circle') {
                    let circle = pmUpdateEvent.layer;
                    let circleLtLng = circle.getLatLng();
                    let circleRadius = circle.getRadius();

                    updateGeofence(id, {type: 'circle', latlng: circleLtLng, radius: circleRadius});
                }
                // Otherwise, just update it as it is using its GeoJSON representation
                else
                    updateGeofence(id, {feature: pmUpdateEvent.layer.toGeoJSON()});

                return;
            }

            initMapGeofences(map, {reInit: true});
        });
    };

    let eventRemovedLayer = (id) => {
        Swal.fire({
            title: 'Confirm Deletion',
            text: 'Deleting this geofence will not be reverted. Would you like to proceed?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Delete',
            reverseButtons: true
        }).then((result) => {
            if(!result.isConfirmed) {
                initMapGeofences(map, {reInit: true});
                return;
            }

            removeGeofence(id);
        });
    };

    let eventCreateLayer = (pmCreateEvent) => {
        Swal.fire({
            title: 'Confirm Create',
            text: 'Do you really want to create this geofence? You can delete this anytime.',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Create',
            reverseButtons: true
        }).then((result) => {
            if(!result.isConfirmed) {
                initMapGeofences(map, {reInit: true});
                return;
            }

            let geomanLayers = map.pm.getGeomanDrawLayers();
            geomanLayers.forEach((geomanLayer) => map.removeLayer(geomanLayer));

            // Save geojson to database
            // If the shape of the layer is a cirlce, let's custom save its properties
            // since GeoJSON doesn't have a spec for circles
            if(pmCreateEvent.shape.toLowerCase() == 'circle') {
                let circle = pmCreateEvent.layer;
                let circleLtLng = circle.getLatLng();
                let circleRadius = circle.getRadius();

                saveGeofence({type: 'circle', latlng: circleLtLng, radius: circleRadius});
            }
            // Otherwise, just save it as it is using its GeoJSON representation
            else
                saveGeofence({feature: pmCreateEvent.layer.toGeoJSON()});
        });
    };

    let initMapGeofences = (map, options = {reInit: false}) => {
        if(options.reInit) {
            layerGroup.clearLayers();

            console.log('reinitiating map');
        }

        // Fetch all saved geofences from the database
        $.get(getGeofencesURL)
            .done(function(data) {
                let geofences = data;

                // If we have geofences saved in the database, display them on the map
                if(geofences.length > 0) {
                    geofences.forEach((geofence) => {
                        let layerGeoJSON = JSON.parse(geofence.geojson);

                        let layer = (layerGeoJSON.type && layerGeoJSON.type == 'circle')
                            ? L.circle(layerGeoJSON.latlng, layerGeoJSON.radius)
                            : L.geoJSON(layerGeoJSON.feature);
                        layerGroup.addLayer(layer);

                        // Fired AFTER editing the layer (after clicking 'Finish')
                        layer.on('pm:update', (pmUpdateEvent) => eventUpdatedLayer(pmUpdateEvent, geofence.id));

                        // Fired AFTER removing the layer
                        layer.on('pm:remove', (pmRemoveEvent) => {
                            console.log(pmRemoveEvent);
                            eventRemovedLayer(geofence.id);
                        });

                        // Fired AFTER cutting the layer
                        layer.on('pm:cut', (pmUpdateEvent) => eventUpdatedLayer(pmUpdateEvent, geofence.id));
                    });
                }

                // Fired after creating a new layer
                map.on('pm:create', eventCreateLayer);

                /**
                 * DRAFTED UNDO/REDO ACTION FOR NOW
                 */
                // // Create custom control for undo action
                // map.pm.Toolbar.createCustomControl({
                //     name: "UndoAction",
                //     block: "custom",
                //     title: "Undo Action",
                //     className: "control-icon undo-action",
                //     disabled: false,
                //     disableOtherButtons: true,
                //     disableByOtherButtons: true,
                //     onClick: () => {
                //         console.log('undo action clicked');

                //         // Check if undo stack isn't empty
                //         if(undoLayersStack.length > 0) {
                //             // Remove the current layer from the undo stack
                //             let currentLayer = undoLayersStack.pop();

                //             // Push the current layer to the redo stack
                //             redoLayersStack.push(currentLayer);

                //             // Remove the current layer from the map
                //             map.removeLayer(currentLayer);

                //             // Display the previous layer from the undo stack to the map
                //             if(undoLayersStack.length > 0)
                //                 map.addLayer(undoLayersStack.at(-1));
                //         }

                //         console.log(undoLayersStack);
                //     },
                // });

                // // Create custom control for redo action
                // map.pm.Toolbar.createCustomControl({
                //     name: "RedoAction",
                //     block: "custom",
                //     title: "Redo Action",
                //     className: "control-icon redo-action",
                //     disabled: false,
                //     disableOtherButtons: false,
                //     disableByOtherButtons: false,
                //     onClick: () => {},
                // });

                // $('.undo-action').append('<i class="mdi mdi-undo"></i>');
                // $('.redo-action').append('<i class="mdi mdi-redo"></i>');

                updateMap();
            })
            .fail(function() {
                console.log('Something went wrong while fetching geofences!');

                return undefined;
            });
    };

    if(url.endsWith('tracking')) {
        map = L.map('map', {pmIgnore: false}).setView(ecoParkLtLng, 18);

        let tile = L.tileLayer(`https://api.mapbox.com/styles/v1/snoopycodex/clir72wpr00ko01r854fsammn/tiles/256/{z}/{x}/{y}@2x?access_token=${import.meta.env.VITE_MAPBOX_ACCESS_TOKEN}`, {
            maxZoom: 19,
            minZoom: 15,
            attribution: '&copy; <a href="http://www.mapbox.com/about/maps">MapBox</a> <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });
        tile.addTo(map);

        layerGroup = L.layerGroup();
        layerGroup.addTo(map);

        map.pm.addControls({
            position: 'topleft',
            drawMarker: false,
            drawCircleMarker: false,
            drawText: false,
        });

        initMapGeofences(map);
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
