/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { GoogleMapLoader, GoogleMap, InfoWindow, Marker } from "react-google-maps";
import mapboxgl from 'mapbox-gl';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';

mapboxgl.accessToken = 'pk.eyJ1IjoiYmFndXNpbmRyYXlhbmEiLCJhIjoiY2trMGhjOXNxMGhjaDJwdGc2dDZqYm4wYyJ9.KqaI3n-Hx5u8ru1umclmgg';

class Mapping extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    openDetail: PropTypes.func.isRequired,
    items: PropTypes.array
  };

  constructor() {
    super();

    this.state = this.getDefaultState();
  }

  componentWillReceiveProps(nextProps) {
    console.log(nextProps.items)
    if (nextProps.items != null) {
      const markers = _.filter(nextProps.items.map((item, index) => {
        if (item.latitude != 0 && item.longitude != 0) {
          return {
            'type': 'Feature',
            'properties': {
              'id':item.id,
              'description':
              `<strong>${item.description}</strong><br>`
            },
            'geometry': {
              'type': 'Point',
              'coordinates': [item.longitude,item.latitude]
            }
          }
          
          // return {
          //   index: index,
          //   position:[item.longitude,item.latitude],
          //   showInfo: false,
          //   marker:mapboxgl.Marker()
          //   .setLngLat([item.longitude, item.latitude])
          // };
        }
      }), (item) => {
        if (item) {
          return item;
        }
      });

      this.setState({markers: {
				'type': 'geojson',
				'data': {
					'type': 'FeatureCollection',
					'features': markers
				}
			}});
    } else {
      this.setState({markers: []});
    }
  }

  getDefaultState() {
    return {
      markers: {
				'type': 'geojson',
				'data': {
					'type': 'FeatureCollection',
					'features': []
				}
			},
      lng: 117.09644814,
      lat: -0.55987814,
      zoom: 2,
      map:null
    };
  }

  render() {
    if (this.props.items == null) {
      return null;
    }

    

    // const latLngCenter = this.getLatLngCenter(this.props.items.map((item) => {
    //   return [item.latitude, item.longitude];
    // }));

    return (
      <div>
          <div className='map-container' id="mapContainer" />
      </div>
      // <GoogleMapLoader containerElement={<div style={{height: '300px'}}></div>}
      //   googleMapElement={
      //     <GoogleMap
      //       containerProps={{style: {
      //         height: '300px',
      //       }}} defaultZoom={10} defaultCenter={latLngCenter}>
      //       {this.state.markers.map((marker, index) => {
      //         const ref = `marker_${index}`;

      //         return (
      //           <Marker key={index} ref={ref} position={marker.position}
      //            title={this.props.items[marker.index].title}
      //            onClick={this.handleMarkerClick.bind(this, marker)}>
      //             {marker.showInfo ? this.renderInfoWindow(ref, marker) : null}
      //           </Marker>
      //         );
                  
      //       })}
      //     </GoogleMap>
       // }
      ///> //end of GoogleMapLoader
    );
  }

  handleShowAreaDetail(index) {
    this.props.openDetail(this.props.items[index]);
  }

  handleMarkerClick(marker) {
    marker.showInfo = true;
    this.setState(this.state);
  }
  
  handleMarkerClose(marker) {
    marker.showInfo = false;
    this.setState(this.state);
  }

  renderInfoWindow(ref, marker) {
    return (
      <InfoWindow key={`${ref}_info_window`}
        onCloseclick={this.handleMarkerClose.bind(this, marker)}>
        <div>
          <h5 className="font-dark bold uppercase">
            <a href="javascript:;" onClick={this.handleShowAreaDetail.bind(this, marker.index)}>{this.props.items[marker.index].title}</a>
          </h5>
          <p className="margin-top-0 margin-bottom-0">
            {this.props.items[marker.index].short_description}
          </p>
          <p className="margin-top-0 margin-bottom-0">
            {this.props.items[marker.index].address}
          </p>
          <p className="margin-top-0 margin-bottom-0">
            {this.props.items[marker.index].village.data.title} - {this.props.items[marker.index].district.data.title}
          </p>
        </div>
      </InfoWindow>
    );
  }


  initMap(){
    const mapContainer = document.getElementById('mapContainer');
    var state = this.state;
    if(mapContainer && this.state.map == null){
      this.state.map = new mapboxgl.Map({
        container: mapContainer,
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [this.state.lng, this.state.lat],
        zoom: this.state.zoom
      });

      const map = this.state.map;

      var geocoder = new MapboxGeocoder({
          accessToken: mapboxgl.accessToken,
          mapboxgl: mapboxgl,
          marker:false,
          placeholder: 'Masukan kata kunci...',
          zoom:20
      });


      map.addControl(
          geocoder
      );
      
      map.on('load',function () {
       

        map.loadImage('https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',function (error, image) {
          if (error) throw error;
          map.addImage('custom-icon', image);
            
          map.addSource('custom-icon', state.markers);
            
          // Add a layer showing the places.
          map.addLayer({
            'id': 'custom-icon',
            'type': 'symbol',
            'source': 'custom-icon',
            'layout': {
              'icon-image': 'custom-icon',
              'icon-allow-overlap': true,
              'icon-offset':[0,-20]
            }
          });
        });
            
          // Create a popup, but don't add it to the map yet.
        var popup = new mapboxgl.Popup({
          closeButton: true,
          closeOnClick: true
        });

       
        map.on('click', 'custom-icon', function (e) {

          map.getCanvas().style.cursor = 'pointer';
            
          var coordinates = e.features[0].geometry.coordinates.slice();
          var description = e.features[0].properties.description;

          while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
          }
   
          popup.setLngLat(coordinates).setHTML(description).addTo(map);
 
        });
      });

 
    }
  }

  componentDidMount(){
    this.initMap();
  }

  componentDidUpdate(){
    const mapContainer = document.getElementById('mapContainer');
    var state = this.state;
    if(state.map != null) {
      const map = this.state.map
      if(map.getSource('custom-icon')){
        map.getSource('custom-icon').setData(state.markers.data);
      }
    } else {
      this.initMap();
    }
    // if(map != null){
    //   for (let i = 0; i < markers.length; i++) {
    //     const m = markers[i];
    //     new mapboxgl.Marker()
    //           .setLngLat(m.position)
    //           .addTo(map);
        
    //   }
    // } else {
    //   this.state.map = new mapboxgl.Map({
    //     container: mapContainer,
    //     style: 'mapbox://styles/mapbox/streets-v11',
    //     center: [this.state.lng, this.state.lat],
    //     zoom: this.state.zoom
    //   });

    //   map = this.state.map;

    //   for (let i = 0; i < markers.length; i++) {
    //     const m = markers[i];
    //     new mapboxgl.Marker()
    //           .setLngLat(m.position)
    //           .addTo(map);
        
    //   }
    // }
  }

  rad2degr(rad) { return rad * 180 / Math.PI; }
  degr2rad(degr) { return degr * Math.PI / 180; }
  getLatLngCenter(items) {
    const LATIDX = 0;
    const LNGIDX = 1;
    let sumX = 0;
    let sumY = 0;
    let sumZ = 0;
    let lat = 0;
    let lng = 0;

    for (let i = 0; i < items.length; i++) {
      if (items[i][LATIDX] != 0 && items[i][LNGIDX] != 0) {
        lat = this.degr2rad(items[i][LATIDX]);
        lng = this.degr2rad(items[i][LNGIDX]);

        // sum of cartesian coordinates
        sumX += Math.cos(lat) * Math.cos(lng);
        sumY += Math.cos(lat) * Math.sin(lng);
        sumZ += Math.sin(lat);
      }
    }

    const avgX = sumX / items.length;
    const avgY = sumY / items.length;
    const avgZ = sumZ / items.length;

    // convert average x, y, z coordinate to latitude and longtitude
    lng = Math.atan2(avgY, avgX);
    const hyp = Math.sqrt(avgX * avgX + avgY * avgY);
    lat = Math.atan2(avgZ, hyp);

    return new google.maps.LatLng(this.rad2degr(lat), this.rad2degr(lng));
  }

}

export default Mapping;
