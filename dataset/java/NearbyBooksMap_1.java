package com.husrevbeyazisik.kitaptakas.main;

import android.Manifest;
import android.content.pm.PackageManager;
import android.location.Location;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.husrevbeyazisik.kitaptakas.R;
import com.husrevbeyazisik.kitaptakas.Settings;
import com.husrevbeyazisik.kitaptakas.helpers.httpconnection.HttpConnection;
import com.husrevbeyazisik.kitaptakas.helpers.httpconnection.HttpConnectionProgressBar;
import com.husrevbeyazisik.kitaptakas.interfaces.IGetString;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Set;

public class NearbyBooksMap extends FragmentActivity implements OnMapReadyCallback, IGetString {

    private GoogleMap mMap;

    private boolean selected = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_nearby_books_map);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        HttpConnectionProgressBar conn = new HttpConnectionProgressBar(this,this);
        conn.ProgressDialogMessage = "Hazırlanıyor";
        conn.execute(Settings.URL + Settings.PHP_GET_NEARBY_BOOKS);

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
                    LatLng loc = new LatLng(location.getLatitude(), location.getLongitude());
                    mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(loc, 16.0f));
                    mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(loc, 16));
                    selected = true;
                }

            }
        };
        mMap.setOnMyLocationChangeListener(myLocationChangeListener);

    }




    @Override
    public void GetString(String string) {



       /* mMap.setOnMapClickListener(new GoogleMap.OnMapClickListener() {
            @Override
            public void onMapClick(LatLng latLng) {
                mMap.addMarker(new MarkerOptions().position(latLng).title(getResources().getString(R.string.book_add_here)));
                mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(latLng, 16));
            }
        });*/




        JSONObject book=null;
        JSONArray books=null;

        String bookName=null;
        int user_id;
        double latitude;
        double longitude;

        try {

            books = new JSONObject(string).getJSONArray(Settings.JSON_NEARBY_BOOKS_ARRAY_NAME);

        } catch (JSONException e) {
            e.printStackTrace();
        }

        for (int i=0;i<books.length();i++)
        {
            try {
                book = books.getJSONObject(i);

                bookName = book.getString(Settings.BOOK_NAME);
                latitude = book.getDouble(Settings.LATITUDE);
                longitude = book.getDouble(Settings.LONGITUDE);
                user_id = book.getInt(Settings.USER_ID);

                LatLng loc = new LatLng(latitude, longitude);

                mMap.addMarker(new MarkerOptions().position(loc).title(bookName + " " + R.string.added_user + " "+Integer.toString(user_id) ));

            } catch (JSONException e) {
                e.printStackTrace();
            }

        }

    }
}
