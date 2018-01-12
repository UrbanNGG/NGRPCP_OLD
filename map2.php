  <?php
  $host="localhost";
	//$host="205.234.203.30";
	$username="cp";
	$password="chuJUstabR2XA3";
	//$password="Swabetrequ2ta4";
	$db_name="ngrp"; 


mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");
?>
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyBirB5jdduWbcqAuy28Xyzu0wrUcnHVJdU" type="text/javascript"></script>
    <script type="text/javascript">

      // EuclideanProjection taken from: http://econym.googlepages.com/example_custommapflat.htm

      // ====== Create the Euclidean Projection for the flat map ======
      // == Constructor ==
      function EuclideanProjection(a){
        this.pixelsPerLonDegree=[];
        this.pixelsPerLonRadian=[];
        this.pixelOrigo=[];
        this.tileBounds=[];
        var b=256;
        var c=1;
        for(var d=0;d<a;d++){
          var e=b/2;
          this.pixelsPerLonDegree.push(b/360);
          this.pixelsPerLonRadian.push(b/(2*Math.PI));
          this.pixelOrigo.push(new GPoint(e,e));
          this.tileBounds.push(c);
          b*=2;
          c*=2
        }
      }
 
      // == Attach it to the GProjection() class ==
      EuclideanProjection.prototype=new GProjection();
 
 
      // == A method for converting latitudes and longitudes to pixel coordinates == 
      EuclideanProjection.prototype.fromLatLngToPixel=function(a,b){
        var c=Math.round(this.pixelOrigo[b].x+a.lng()*this.pixelsPerLonDegree[b]);
        var d=Math.round(this.pixelOrigo[b].y+(-2*a.lat())*this.pixelsPerLonDegree[b]);
        return new GPoint(c,d)
      };

      // == a method for converting pixel coordinates to latitudes and longitudes ==
      EuclideanProjection.prototype.fromPixelToLatLng=function(a,b,c){
        var d=(a.x-this.pixelOrigo[b].x)/this.pixelsPerLonDegree[b];
        var e=-0.5*(a.y-this.pixelOrigo[b].y)/this.pixelsPerLonDegree[b];
        return new GLatLng(e,d,c)
      };

      // == a method that checks if the y value is in range, and wraps the x value ==
      EuclideanProjection.prototype.tileCheckRange=function(a,b,c){
        var d=this.tileBounds[b];
        if (a.y<0 || a.y>=d || a.x<0 || a.x>=d) {
          return false;
        }
        return true
      }

      // == a method that returns the width of the tilespace ==      
      EuclideanProjection.prototype.getWrapWidth=function(zoom) {
        return this.tileBounds[zoom]*256;
      }
	  
	  
	// Here comes the dmap specific stuff:

	var gtasaIcons = {};
	var markers = [];
	var markersText = [];
	var map = null;
	
	function fetchData() {
		var data = '{"items":{"p104":{"id":104,"name":"House ID: <?php echo $id - 1; ?>","pos":{"x":<?php echo $x; ?>,"y":<?php echo $y; ?>},"owner":"Owner: <?php echo $owner; ?>","zone":"Location: <?php echo $zone; ?>","icon":31}<?php if(isset($id2)) { ?>,"p106":{"id":106,"name":"House ID: <?php echo $id2 - 1; ?>","pos":{"x":<?php echo $x2; ?>,"y":<?php echo $y2; ?>},"owner":"<?php echo $owner2; ?>","zone":"<?php echo $zone2; ?>","icon":31}<?php }
		$iconquery = mysql_query("SELECT * FROM `dmapicons` WHERE `PosX` <> '0.00000' AND `PosY` <> '0.00000'");
		$num = 120;
			while ($icon = mysql_fetch_array($iconquery)) {
			$ddquery = mysql_query("SELECT `Description` FROM `ddoors` WHERE (`ExteriorX` = '$icon[PosX]' OR (`ExteriorX` < $icon[PosX] + 5 AND `ExteriorX` > $icon[PosX] - 5)) AND (`ExteriorY` = '$icon[PosY]' OR (`ExteriorY` < $icon[PosY] + 5 AND `ExteriorY` > $icon[PosY] - 5))");
			$ddname = mysql_fetch_array($ddquery);
				$num++;
				$dynzone = GetPlayer2DZone($icon['PosX'], $icon['PosY']);
				echo ',"p'.$num.'":{"id":'.$num.',"name":"Icon ID: '.$icon["id"].'","pos":{"x":'.$icon["PosX"].',"y":'.$icon["PosY"].'},"owner":"'.addslashes($ddname["Description"]).'","zone":"'.$dynzone.'","icon":'.$icon["MarkerType"].'}';
			}
		?>}}';
			data = eval("("+data+")");
			if (typeof data.items !== "undefined") {
				for (id in data.items) {
					var item = data.items[id];
					var point = new GLatLng(((parseFloat(item.pos.y)*90)/3000),
								((parseFloat(item.pos.x)*90)/1500));
					if (typeof markers[item.id] === "undefined" || markers[item.id] === null) {
						markers[item.id] = {}
						var marker = createMapMarker(point, item.id, item.owner, item.icon);
						markers[item.id].marker = marker;
						markers[item.id].id = item.id;
						markersText[item.id] = "<b>" + item.name + "</b><br/>"+ item.zone +"<br />"+ item.owner;
						map.addOverlay(markers[item.id].marker);
					}
				}
			}
	}

    function load() {
		document.getElementById('map').style.width="500px";
		document.getElementById('map').style.height="350px";
		

		if (GBrowserIsCompatible()) {
			map = new GMap2(document.getElementById("map"));

			var copyright = new GCopyright(1, new GLatLngBounds(new GLatLng(-180, -180), new GLatLng(180, 180)), 0);
			var copyrights = new GCopyrightCollection('');
			copyrights.addCopyright(copyright);
			var tilelayer = new GTileLayer(copyrights, 1, 4);
			tilelayer.getTileUrl = function(tile, zoom) { 
			return 'http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/map/'+tile.x+'x'+tile.y+'-'+(6-zoom)+".jpg"; };
			var CUSTOM_MAP = new GMapType( [tilelayer], new EuclideanProjection(20), "NGG" );
			map.addMapType(CUSTOM_MAP);
			map.setMapType(CUSTOM_MAP);
			map.addControl(new GSmallMapControl());
			map.enableScrollWheelZoom();
			map.setCenter(new GLatLng(((parseFloat(<?php echo $y; ?>)*90)/3000), ((parseFloat(<?php echo $x; ?>)*90)/1500)), 4);
			fetchData();
			setInterval("fetchData();",5000);
		}
    }
	
	function createMapMarker(point, id, text, type) {
	
	if (typeof gtasaIcons[type] === "undefined") {
		var icon = new GIcon(); 
		icon.image = 'http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/icons/Icon_'+type+'.gif';
		icon.iconSize = new GSize(20, 20);
		icon.iconAnchor = new GPoint(10, 10);
		// If I would HAVE this shado icons, I would add them :-P
		// icon.shadowSize = new GSize(22, 20);
		// icon.shadow = 'icons/Icon_'+type+'.gif';
		icon.infoWindowAnchor = new GPoint(1, 1);
		gtasaIcons[type] = icon;
	}
	
      var marker = new GMarker(point, gtasaIcons[type]);
      GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(markersText[id]);
      });
      return marker;
    }

    //]]>
    </script>

  <body onload="load()" onunload="GUnload()">
    <div id="map"></div>
	<?php echo MapLocation($_POST['name'], $house['id'], $house['ExteriorX'], $house['ExteriorY'], $house['Owner']); ?>
  </body>