
var buy_location_points = [];
var activeDepot;
var centerLatLngPosn;
var locations_map;
var depotMapMarker;
var activeDepotMapMarker;
var infoBox;

function initiate_buy_locations_map() {
	centerLatLngPosn = new google.maps.LatLng(1.592812, 32.805176);
	locations_map = new google.maps.Map(document.getElementById("locations-map"), {
		center: centerLatLngPosn,
		zoom: 7,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	depotMapMarker = new google.maps.MarkerImage(
		'/sites/adriko/themes/site_theme/images/mapmarker-depot-black.png',
		new google.maps.Size(20, 24),
		new google.maps.Point(0, 0),
		new google.maps.Point(10, 24)
	);
	activeDepotMapMarker = new google.maps.MarkerImage(
		'/sites/adriko/themes/site_theme/images/mapmarker-depot-orange.png',
		new google.maps.Size(20, 24),
		new google.maps.Point(0, 0),
		new google.maps.Point(10, 24)
	);
	infoBox = new InfoBox({
		content: '',
		disableAutoPan: false,
		maxWidth: 176,
		pixelOffset: new google.maps.Size(-88, -254),
		zIndex: null,
		boxStyle: { 
			background: "#cb4f24",
			opacity: 0.9,
			width: "176px",
			height: "230px"
		},
		closeBoxMargin: "2px 2px 2px 2px",
		closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
		infoBoxClearance: new google.maps.Size(1, 1),
		isHidden: false,
		pane: "floatPane",
		enableEventPropagation: false
	});
	
	google.maps.event.addListener(infoBox, "closeclick", function (e) {
		if (activeDepot) {
			activeDepot.switchOff();
		}
		activeDepot = null;
	});
	
	for (var i=0; i<buy_location_points.length; i++) {
		var data = {
			lat	:	buy_location_points[i].lat,
			lon	:	buy_location_points[i].lon
		}
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(data.lat, data.lon),
			map: locations_map,
			icon: depotMapMarker
		});
		
		//make desc str
		var desc_str = '<div class="marker-caption"><div class="title">'+buy_location_points[i].name+'</div>';
		if (buy_location_points[i].phone) desc_str += '<div class="phone contact"><label>Phone:</label><span>'+buy_location_points[i].phone+'</span></div>';
		if (buy_location_points[i].address) desc_str += '<div class="address contact"><label>Address:</label><span>'+buy_location_points[i].address+'</span></div>';
		desc_str += '</div>';
		
		//marker box
		data.content = document.createElement("div");
		data.content.style.cssText = "border-radius: 3px;";
		data.content.innerHTML = desc_str;
		
		//make depot object
		new depot(data, marker);
	}
}

function depot(data, marker) {
	this.data = data; //lat, lon, content
	this.marker = marker;
	var thisRef = this;
	
	google.maps.event.addListener(marker, "click", function (e) {
		if (activeDepot) {
			activeDepot.switchOff();
		}
		if (infoBox) {
			infoBox.close();
		}
		infoBox.setContent(thisRef.data.content);
		infoBox.open(locations_map, thisRef.marker);
		thisRef.switchOn();
		activeDepot = thisRef;
	});
}

depot.prototype.switchOff = function () {
	this.marker.setIcon(depotMapMarker);
};

depot.prototype.switchOn = function () {
	this.marker.setIcon(activeDepotMapMarker);
};
