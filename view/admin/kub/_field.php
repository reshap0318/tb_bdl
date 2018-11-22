<?php if(isset($_GET['id'])){ ?>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Nama KUB</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $data['nama']; ?>"  id="nama" name="nama" placeholder="ex : mentokin dong">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Alamat</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $data['alamat']; ?>"  id="alamat" name="alamat" placeholder="ex : jalan rambun bulan no 17 padang">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Tanggal Berdiri</label>
      <div class="col-sm-10">
          <input type="date" value="<?php echo $data['tgl_berdiri']; ?>" class="form-control" name="tgl_berdiri">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Deskripsi</label>
      <div class="col-sm-10">
        <textarea name="deskripsi" class="form-control" rows="8" cols="80" ><?php echo $data['deskripsi']; ?></textarea>
        <span class="messages popover-valid"></span>
      </div>
  </div>

  <!-- geom fiel -->
  <div class="form-group col-sm-12">
      <div id="map-content" style="width:100%;height:420px; z-index:50"></div>
      <div class="text-center col-sm-12">
        <a class="btn btn-danger btn-round btn-sm" id="delete-button" href="#">Delete</a>
      </div>
      <br>
      <div class="col-sm-12">
        <input type="text" name="geom" value="<?php echo $data['geom']; ?>" id="geom" class="form-control">
      </div>
  </div>
<?php }else{?>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Nama KUB</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value=""  id="nama" name="nama" placeholder="ex : mentokin dong">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Alamat</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value=""  id="alamat" name="alamat" placeholder="ex : jalan rambun bulan no 17 padang">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Tanggal Berdiri</label>
      <div class="col-sm-10">
          <input type="date" class="form-control" name="tgl_berdiri">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Deskripsi</label>
      <div class="col-sm-10">
        <textarea name="deskripsi" class="form-control" rows="8" cols="80"></textarea>
        <span class="messages popover-valid"></span>
      </div>
  </div>

  <!-- geom fiel -->
  <div class="form-group col-sm-12">
      <div id="map-content" style="width:100%;height:420px; z-index:50"></div>
      <div class="text-center col-sm-12">
        <a class="btn btn-danger btn-round btn-sm" id="delete-button" href="#">Delete</a>
      </div>
      <br>
      <div class="col-sm-12">
        <input type="text" name="geom" value="" id="geom" class="form-control">
      </div>
  </div>
<?php } ?>

  <script>
      var drawingManager;
      var selectedShape;
      var map;

      function initMap() {
          map = new google.maps.Map(document.getElementById('map-content'),{
              center: new google.maps.LatLng(-0.94924, 100.35427),
              zoom: 16,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              disableDefaultUI: true,
              zoomControl: true,
              mapTypeControl: true
          });

          infoWindow = new google.maps.InfoWindow;

          if (navigator.geolocation)
          {
            navigator.geolocation.getCurrentPosition(function(position)
            {
              var pos =
              {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };

              infoWindow.setPosition(pos);
              infoWindow.setContent('Lokasi Saya.');
              infoWindow.open(map);
              map.setCenter(pos);
            },
            function()
            {
              handleLocationError(true, infoWindow, map.getCenter());
            });
          } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
          }

          var polyOptions = {
              fillColor: 'blue',
              strokeColor: 'blue',
              draggable: false
          };

          drawingManager = new google.maps.drawing.DrawingManager({
              drawingMode: google.maps.drawing.OverlayType.POLYGON,
              drawingControlOptions: {
                  position: google.maps.ControlPosition.TOP_LEFT,
                  drawingModes: [
                      google.maps.drawing.OverlayType.POLYGON
                  ]
              },
              polygonOptions: polyOptions,
              map: map
          });

          //event digitasi di google map
          google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event){
              if (event.type == google.maps.drawing.OverlayType.POLYGON){
                  //console.log('polygon path array', event.overlay.getPath().getArray());
                  var str_input ='((';
                  var i=0;
                  var coor = [];
                  $.each(event.overlay.getPath().getArray(), function(key, latlng){
                      var lat = latlng.lat();
                      var lon = latlng.lng();
                      coor[i] = lon +' '+ lat;
                      str_input += lon +' '+ lat +',';
                      i++;
                  });
                  str_input = str_input+''+coor[0]+'))';
                  $("#geom").val(str_input);
                  drawingManager.setDrawingMode(null);
                  drawingManager.setOptions({
                      drawingControl: false
                  });
                  // Add an event listener that selects the newly-drawn shape when the user mouses down on it.
                  var newShape = event.overlay;
                  newShape.type = event.type;
                  setSelection(newShape);
                  google.maps.event.addListener(newShape, 'click', function(){
                      setSelection(newShape);
                  });
              }
              function getCoordinate(){
                  var polygonBounds = newShape.getPath();
                  str_input ='((';
                  for(var i = 0 ; i < polygonBounds.length ; i++){
                      coor[i] = polygonBounds.getAt(i).lng() +' '+ polygonBounds.getAt(i).lat();
                      str_input += polygonBounds.getAt(i).lng() +' '+ polygonBounds.getAt(i).lat() +',';
                  }
                  str_input = str_input+''+coor[0]+'))';
                  $("#geom").val(str_input);
              }
              google.maps.event.addListener(newShape.getPath(), 'set_at', getCoordinate);
              google.maps.event.addListener(newShape.getPath(), 'insert_at', getCoordinate);
              google.maps.event.addListener(newShape.getPath(), 'remove_at', getCoordinate);
          });
          google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
          google.maps.event.addListener(map, 'click', clearSelection);
          google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

          drawingManager.setMap(map);
      }

      function clearSelection() {
          if (selectedShape) {
              selectedShape.setEditable(false);
              selectedShape = null;
          }
      }

      function setSelection(shape) {
          clearSelection();
          selectedShape = shape;
          shape.setEditable(true);
      }

      function deleteSelectedShape() {
          if (selectedShape) {
              $("#geom").val('');
              selectedShape.setMap(null);
              drawingManager.setOptions({
                  drawingControl: true
              });
          }
      }

  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIhFclffR-6pgFqaUP_d7ZU8fEUhCflZ0&libraries=drawing&callback=initMap"></script>
