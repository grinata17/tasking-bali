<!DOCTYPE html>
<html>
<head> <!-- untuk meta description, keywords, dan author bisa gantu dan di sesuaikan tapi yang meta charset sama viewport jangan di ganti -->
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name='description' content='WebGIS geosis.id menyajikan berbagai konten spasial ke dalam bentuk Website'/>
<meta name='keywords' content='WebGIS, WebGIS geos, WebGIS Indoensia'/>
<meta name='Author' content='Egi Septiana'/> 
<title>WebGIS Geospasial Denpasar</title> <!-- title bisa di sesuaikan dengan nama judul WebGIS yang di inginkan -->
<link rel="stylesheet" href="leaflet/leaflet.css" /> <!-- memanggil css di folder leaflet -->
<link rel="stylesheet" href="css/style.css" /> <!-- memanggil css style -->
<script src="js/jquery-3.6.3.min.js"></script> <!-- memanggil jquery di folder js -->
<script src="leaflet/leaflet.js"></script> <!-- memanggil leaflet.js di folder leaflet -->
<script src="leaflet/leaflet-providers-master/leaflet-providers.js"></script> <!-- memanggil leaflet-providers.js di folder leaflet provider -->
<link rel="stylesheet" href="leaflet/leaflet.defaultextent-master/dist/leaflet.defaultextent.css" />
<script src="leaflet/leaflet-ajax-gh-pages/dist/leaflet.ajax.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script> <!-- tambahan link JS berikut agar tool pencarian yang baru yang sudah diganti dengan CSS Dan JS -->
<script src="leaflet/leaflet.defaultextent-master/dist/leaflet.defaultextent.js"></script>
<link rel="stylesheet" href="leaflet/leaflet-groupedlayercontrol-gh-pages/leaflet-groupedlayercontrol-gh-pages/src/leaflet.groupedlayercontrol.css"/>
<script src="leaflet/leaflet-groupedlayercontrol-gh-pages/leaflet-groupedlayercontrol-gh-pages/src/leaflet.groupedlayercontrol.js"></script> 
<link rel="stylesheet" href="css/bootstrap-4.6.3-dist/css/bootstrap.min.css"/> <!-- memanggil Bootstrap di folder css -->
<!-- <link rel="stylesheet" href="css/fontawesome-free-6.4.0-web/css/fontawesome.min.css"/>  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></link>
<link rel="stylesheet" href="css/popup-menu.css" />
<link rel="stylesheet" href="https://icon-icons.com/id/icon/pencarian/64617"/>
<script src="startbootstrap-agency-gh-pages/jss/scripts.js"></script>
</head>
<body>

<!-- INI HEADER -->
<div id="header">
<h2><a href="http://geosis.id">GEOSPASIAL KOTA DENPASAR</a></h2>
<nav class="menu-header">
<ul>
<li><i class="fa-solid fa-info" style="font-size:13px; color:#9FDFFF;"></i><a href="#info">INFO</a></li>
<li><i class="fa-solid fa-map-location-dot" style="font-size:13px; color:#9FDFFF;"></i><a href="#legenda">LEGENDA</a></li>
<li><i class="fa-solid fa-download" style="font-size:13px; color:#9FDFFF;"></i><a href="#download">DOWNLOAD</a></li>
<li class="right"><i class="fa fa-lock" style="font-size:13px; color:#9FDFFF;"></i><a href="#">LOGIN</a></li>
</ul>
</nav>
</div>
<!-- <div class="container"> -->
<div id="map"></div> <!-- ini id="map" bisa di ganti dengan nama yang di inginkan -->
<!-- </div> -->

<script>

// MENGATUR TITIK KOORDINAT TITIK TENGAN & LEVEL ZOOM PADA BASEMAP
var map = L.map('map').setView([-8.75897398,115.21438498], 11);
var peta = new L.LayerGroup();
var items = [];
// MENAMPILKAN SKALAs
L.control.scale({imperial: false}).addTo(map);

// ------------------- VECTOR ----------------------------
// REQUEST BALI ADMINISTRASI
var layer_ADMINISTRASI = new L.GeoJSON.AJAX("layer/kota_denpasar_bali.php",{ 
    style: function(feature){
    var fillColor = feature.properties.color; // PEWARNAAN OBJEK POLYGON DIAMBIL DARI FIELD "color" PADA FILE GEOJSON
        return {color: "#999", dashArray: '3', weight: 2, fillColor: fillColor, fillOpacity: 0.5 }; // Berikan efek trasparan pada bagian "fillOpacity" agar basemap dapat terlihat
      },
      onEachFeature: function(feature, layer){
        items.push(layer); // ini dibuat untuk menghubungkan variabel items ke dalam layer, ini berfungsi untuk menjalankan tool pencarian
      layer.bindPopup("<center>" + feature.properties.nama + "</center>"), // popup yang akan ditampilkan diambil dari filed nama
      that = this; // perintah agar menghasilkan efek hover pada objek layer

            layer.on('mouseover', function (e) {
                this.setStyle({
                weight: 2,
                color: '#33D900',
                dashArray: '',
                fillOpacity: 0.8  
                });

            if (!L.Browser.ie && !L.Browser.opera) {
                layer.bringToFront();
            }

          
            });
            layer.on('mouseout', function (e) {
                layer_ADMINISTRASI.resetStyle(e.target); // isi dengan nama variabel dari layer
                
            });
    }
    }).addTo(peta); // layer peta admiinistrasi ini ditmbahkan ke dalam variabel 'peta'


 // GEOLOGI KOTA DENPASAR
 var layer_GEOLOGI = new L.GeoJSON.AJAX("layer/geologi_denpasar_bali.php",{ 
    style: function(feature){
    var fillColor = feature.properties.color; // PEWARNAAN OBJEK POLYGON DIAMBIL DARI FIELD "color" PADA FILE GEOJSON
        return {color: "#999", dashArray: '3', weight: 2, fillColor: fillColor, fillOpacity: 0.5 }; // Berikan efek trasparan pada bagian "fillOpacity" agar basemap dapat terlihat
      },
      onEachFeature: function(feature, layer){
        items.push(layer); // ini dibuat untuk menghubungkan variabel items ke dalam layer, ini berfungsi untuk menjalankan tool pencarian
      layer.bindPopup("<center>" + feature.properties.nm_lembar + "</center>"), // popup yang akan ditampilkan diambil dari filed nama
      that = this; // perintah agar menghasilkan efek hover pada objek layer

            layer.on('mouseover', function (e) {
                this.setStyle({
                weight: 2,
                color: '#DA9034',
                dashArray: '',
                fillOpacity: 0.8
                });

            if (!L.Browser.ie && !L.Browser.opera) {
                layer.bringToFront();
            }

            
            });
            layer.on('mouseout', function (e) {
                layer_GEOLOGI.resetStyle(e.target); // isi dengan nama variabel dari layer
              
            });
    }
    }).addTo(peta); // layer peta administrasi ini ditmbahkan ke dalam variabel 'peta'

// membuat temaplate

    // MENAMBAHKAN TOOL PENCARIAN
// SEARCH TOOL
function sortNama(a, b) {
  var _a = a.feature.properties.nama; // nama field yang akan dijadikan acuan di dalam tool pencarian
  var _b = b.feature.properties.nama; // nama field yang akan dijadikan acuan di dalam tool pencarian
  if (_a < _b) {
    return -1;
  }
  if (_a > _b) {
    return 1;
  }
  return 0;
}

L.Control.Search = L.Control.extend({
  options: {
    // topright, topleft, bottomleft, bottomright
    position: 'topleft',
    placeholder: ' Search...'

  },
  initialize: function (options /*{ data: {...}  }*/) {
    // constructor
    L.Util.setOptions(this, options);
  },
  onAdd: function (map) {
    // happens after added to map
    var container = L.DomUtil.create('div', 'search-container');
    this.form = L.DomUtil.create('form', 'form', container);
    var group = L.DomUtil.create('div', 'form-group', this.form);
    this.input = L.DomUtil.create('input', 'form-control input-sm', group);
    this.input.type = 'text';
    this.input.placeholder = this.options.placeholder;
    this.results = L.DomUtil.create('div', 'list-group', group);
    L.DomEvent.addListener(this.input, 'keyup', _.debounce(this.keyup, 300), this);
    L.DomEvent.addListener(this.form, 'submit', this.submit, this);
    L.DomEvent.disableClickPropagation(container);
    return container;
  },
  onRemove: function (map) {
    // when removed
    L.DomEvent.removeListener(this._input, 'keyup', this.keyup, this);
    L.DomEvent.removeListener(form, 'submit', this.submit, this);
  },
  keyup: function(e) {
    if (e.keyCode === 38 || e.keyCode === 40) {
      // do nothing
    } else {
      this.results.innerHTML = '';
      if (this.input.value.length > 2) {
        var value = this.input.value;
        var results = _.take(_.filter(this.options.data, function(x) {
          return x.feature.properties.nama.toUpperCase().indexOf(value.toUpperCase()) > -1;
        }).sort(sortNama), 10);
        _.map(results, function(x) {
          var a = L.DomUtil.create('a', 'list-group-item');
          a.href = '';
          a.setAttribute('data-result-name', x.feature.properties.nama); // nama field yang akan dijadikan acuan di dalam tool pencarian
          a.innerHTML = x.feature.properties.nama; // nama field yang akan dijadikan acuan di dalam tool pencarian
          this.results.appendChild(a);
          L.DomEvent.addListener(a, 'click', this.itemSelected, this);
          return a;
        }, this);
      }
    }
  },
  itemSelected: function(e) {
    L.DomEvent.preventDefault(e);
    var elem = e.target;
    var value = elem.innerHTML;
    this.input.value = elem.getAttribute('data-result-name');
    var feature = _.find(this.options.data, function(x) {
      return x.feature.properties.nama === this.input.value; // nama field yang akan dijadikan acuan di dalam tool pencarian
    }, this);
    if (feature) {
      this._map.fitBounds(feature.getBounds());
    }
    this.results.innerHTML = '';
  },
  submit: function(e) {
    L.DomEvent.preventDefault(e);
  }
});

L.control.search = function(id, options) {
  return new L.Control.Search(id, options);
}
L.control.search({
  data: items 
}).addTo(map);



// menambahkan tools defautl extent
L.control.defaultExtent().addTo(map);

// PILIHAN BASEMAP YANG AKAN DITAMPILKAN
var baseLayers
= {  
  'Esri.WorldTopoMap': L.tileLayer.provider('Esri.WorldTopoMap').addTo(map),
  'Esri WorldImagery': L.tileLayer.provider('Esri.WorldImagery')
};

// membuat pilihan untuk menampilkan layer
var overlays = {
      "KOTA DENPASAR": {
        "Administrasi": layer_ADMINISTRASI,
        "Geologi": layer_GEOLOGI 
      }
      };
  var options = {
  exclusiveGroups: ["KOTA DENPASAR"]
};

// MENAMPILKAN TOOLS UNTUK MEMILIH BASEMAP
L.control.groupedLayers(baseLayers, overlays, {
  position: "bottomleft"
}).addTo(map);
</script>

<template>
  <Svg-icon type="mdi" :path="path"></Svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiSearchWeb } from '@mdi/js';

export default {
  name: "my-component",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiSearchWeb,
    }
  }
}
</script>


<!-- ISI MENU INFO-->
<div id="info">
            <div class="window1">
            <a href='#' class='close-button' title='Close'>Close</a>
            <h1>SELAMAT DATANG</h1>
<p>WebGIS (geographic information system) kami, dibuat dengan tujuan untuk berbagi ilmu mengenai proses pembuatan WebGIS. ini menjadi contoh nyata bagi anda perihal hasil dari proses pembelajaran/pembuatan WebGIS yang di jalani. Beberapa artikel terkait proses pembuatan WebGIS ini sudah dibaca dan di perlajari oleh banyak orang dan banyak apresiasi serta tanggapan yang cukup positif dari anda.</p><br>
<p>Hal tersebut mendorong kami untuk terus berusaha membagi ilmu serta pengetahun terkait Geospasial, khususnya Pembuatan WebGIS kepada anda serta pengikut kami.</p><br>
<p>Terimkasih kami ucapkan kepada anda, dan mudah-mudahan artikel-artikel tutorial yang di bagikan di kami dapat bermanfaat, dan tidak lupa diharapkan adanya tanggapan berupa kritik maupun saran bilamana ada hal-hal yang dirasa salah atau kurang tepat terkait konten artikel yang di bagian.</p><br>
<center><strong>GRINATA LITAMAHUPUTTY</strong></center>
     </div>
   </div>
<!--  MENU INFO END--> 

<div id="legenda">
            <div class="window2">
            <a href='#' class='close-button' title='Close'>Close</a>
            <h1>LEGENDA/KETERANGAN</h1>
            <hr>
   <p style="text-align:center;"><strong>ADMINISTRASI</strong></p>
            <div class="table-responsive">
                        <?php
include "inc/koneksi_DB.php";
?>
              <table class="table table-bordered table-hover tablesorter" align="center">
                <thead>
                  <tr>
                    <th style="text-align:center;">Simbol</th>
                    <th style="text-align:center;">Kecamatan</th>
                    <th style="text-align:center;">Kode Kecamatan</th>
                    <th style="text-align:center;">Provinsi</th>
                  </tr>
                </thead>
                <tbody>
                <?php 

  $queri = pg_query("Select * From kotadenpasar order by id asc") or die ();
while ($data = pg_fetch_array ($queri)) {
?>
<tr>
<td align=center><div class="area" style="background-color:<?php echo $data['color']; ?>"></div></td>
   <td width=35% align=center><?php echo $data['nama']; ?></td>
   <td width=20% align=center><?php echo $data['kdpkab']; ?></td>
   <td width=30% align=center><?php echo $data['wadmpr']; ?></td>
   </tr>
   <?php
   }
   ?>
                </tbody>
              </table>
              </div>
              <hr>
    <p style="text-align:center;"><strong>GEOLOGI</strong></p>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter" align="center">
                <thead>
                  <tr>
                    <th style="text-align:center;">Simbol</th>
                    <th style="text-align:center;">Nama</th>
                    <th style="text-align:center;">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
    $queri = pg_query("Select * From geologi_denpasar order by id asc") or die ();
while ($data = pg_fetch_array ($queri)) {
?>
<tr>
<td align=center><div class="area" style="background-color:<?php echo $data['color']; ?>"></div></td>
   <td width=20% align=center><?php echo $data['symbols']; ?></td>
   <td width=65% align=center><?php echo $data['nm_lembar']; ?></td>
   </tr>
   <?php
   }
   ?>
                </tbody>
              </table>
              </div>
     </div>
   </div>

   <div id="download">
          <div class="window3">
               <a href="#",  class="close-button" title="Close">Close</a>
               <h1>DOWNLOAD</h1>
              <table class="table table-hover" align=center>
              <tr>
              <td>Administrasi</td>
              <td><a href="http://localhost:8080/geoserver/ona/ows?service=WFS&version=1.1.0&request=GetFeature&typeName=ona:kotadenpasar&maxFeatures=50&outputFormat=SHAPE-ZIP">SHP</a></td>
              <td><a href="http://localhost:8080/geoserver/ona/ows?service=WFS&version=1.1.0&request=GetFeature&typeName=ona:kotadenpasar&maxFeatures=50&outputFormat=application%2Fvnd.google-earth.kml%2Bxml">KML</a></td>
              </tr>
              <tr>
              <td>Geologi</td>
              <td><a href="http://localhost:8080/geoserver/ona/ows?service=WFS&version=1.1.0&request=GetFeature&typeName=ona:geologi_denpasar&maxFeatures=50&outputFormat=SHAPE-ZIP">SHP</a></td>
              <td><a href="http://localhost:8080/geoserver/ona/ows?service=WFS&version=1.1.0&request=GetFeature&typeName=ona:geologi_denpasar&maxFeatures=50&outputFormat=application%2Fvnd.google-earth.kml%2Bxml">KML</a></td>
              </tr>
              </table>
           </div>
   </div>


<!-- INI FOOTER -->
<footer id="footer">
<p>Copyright © 2017 <a href="http://geosis.id">Tentang Kami</a></p>
<nav class="menu-footer">
<ul>
<li><a href="https://geosis.id/blog/membuat-webgis-dengan-leaflet-javascript-part-4">TOS</a></li>
<i class="fa-solid fa-lock fa-1x"></i>
<li><a href="https://geosis.id/privacy-policy">PRIVACY POLICY</a></li>
<i class="fa-brands fa-square-instagram fa-1x"></i>
<li><a href="https://www.instagram.com/grinata17/">CONTACT</a></li>
</ul>
</nav>
</footer>

</body>
</html>
