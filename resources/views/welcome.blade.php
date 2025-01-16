<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex w-full">
        <div class="p-4 h-screen w-2/3">
            <div class="py-3">Contoh Map</div>
            <div id="mapId" style="" class="h-4/5 w-full rounded-md shadow-md"></div>
        </div>
        <div class="p-4">
            <div class="py-3">Deskripsi</div>
            <div id="desc"></div>
        </div>
    </div>

    <script>
        const bakorwil = L.latLng(-7.1586871004596, 113.48242286917223);
        const tuguPahlawan = L.latLng(-7.245509225516043, 112.73786093210295);
        const ua = L.latLng(-7.064301229025715, 113.67476463269232);
        const gemma = L.latLng(-7.109472691376892, 113.6723473310594);

        // Convert to waypoints
        const wp_bakorwil = new L.Routing.Waypoint(bakorwil);
        const wp_tugu = new L.Routing.Waypoint(tuguPahlawan);
        const wp_ua = new L.Routing.Waypoint(ua);
        const wp_gemma = new L.Routing.Waypoint(gemma);

        var map = L.map('mapId').setView(ua, 20);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker(ua).addTo(map)
            .bindPopup('A pretty CSS popup.<br> Easily customizable.')

        const jalan = L.Routing.control({
            waypoints: [ua, gemma]
        });
        // jalan.addTo(map);

        let myRoute = L.Routing.osrmv1();
        myRoute.route([wp_ua, wp_gemma], (err,routes) => {
            console.log(routes);
            if(!err){
                let best = 1000000000000;
                let bestRoute = 0;
                for(i in routes){
                    if(routes[i].summary.totalDistance < best){
                        bestRoute = i;
                        best = routes[i].summary.totalDistance;
                    }
                }
                // console.log("Best Route: ", routes[bestRoute]);
                L.Routing.line(routes[bestRoute], {
                    styles : [
                        {
                            color : '#00b4d8',
                            weight : 10,
                        }
                    ]
                }).addTo(map);
            }
            console.log(err);
        })
    </script>
</body>

</html>
