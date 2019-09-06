package com.husrevbeyazisik.kitaptakas.main.fragments.addbook;

import android.Manifest;
import android.content.pm.PackageManager;
import android.location.Location;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.husrevbeyazisik.kitaptakas.R;

public class MapGoogle extends FragmentActivity implements OnMapReadyCallback {


    Button btnAddLocation;

    private GoogleMap mMap;

    private boolean selected = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map_google);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

            btnAddLocation = (Button) findViewById(R.id.btnAddLocation);



        btnAddLocation.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });

        Toast.makeText(this, "Yer seçmek için tıklayın", Toast.LENGTH_LONG).show();
    }


    /**
     * Manipulates the map once available.
     * This callback is triggered when the map is ready to be used.
     * This is where we can add markers or lines, add listeners or move the camera. In this case,
     * we just add a marker near Sydney, Australia.
     * If Google Play services is not installed on the device, the user will be prompted to install
     * it inside the SupportMapFragment. This method will only be triggered once the user has
     * installed Google Play services and returned to the app.
     */
    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;


        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        mMap.setMyLocationEnabled(true);




        //going to user location
        mMap.setMyLocationEnabled(true);
        GoogleMap.OnMyLocationChangeListener myLocationChangeListener = new GoogleMap.OnMyLocationChangeListener() {
            @Override
            public void onMyLocationChange(Location location) {

                if(!selected)
                {
                mMap.clear();
                LatLng loc = new LatLng(location.getLatitude(), location.getLongitude());
                mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(loc, 16.0f));

                    com.husrevbeyazisik.kitaptakas.Location.latitude = loc.latitude;
                    com.husrevbeyazisik.kitaptakas.Location.longitude = loc.longitude;
                    com.husrevbeyazisik.kitaptakas.Location.selected = true;

                    mMap.addMarker(new MarkerOptions().position(loc).title(getResources().getString(R.string.book_add_here)));
                    mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(loc, 16));
                    selected = true;
                }

            }
        };
        mMap.setOnMyLocationChangeListener(myLocationChangeListener);



        mMap.setOnMapClickListener(new GoogleMap.OnMapClickListener() {
            @Override
            public void onMapClick(LatLng latLng) {

                mMap.clear();
                mMap.addMarker(new MarkerOptions().position(latLng).title(getResources().getString(R.string.book_add_here)));
                mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(latLng, 16));


                com.husrevbeyazisik.kitaptakas.Location.latitude = latLng.latitude;
                com.husrevbeyazisik.kitaptakas.Location.longitude = latLng.longitude;
                com.husrevbeyazisik.kitaptakas.Location.selected = true;




            }
        });



    }
}
