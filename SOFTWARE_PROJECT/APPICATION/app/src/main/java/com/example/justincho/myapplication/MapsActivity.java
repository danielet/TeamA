package com.example.justincho.myapplication;

import android.app.ActivityManager;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CircleOptions;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.model.PolylineOptions;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Locale;

public class MapsActivity extends FragmentActivity implements OnMapReadyCallback {

    Handler myHandler;
    TextView Time, Time2, Time3, CO, CO2, CO3, SO2, SO22, SO23, NO2, NO22, NO23, O3, O32, O33, PM2, PM22, PM23, PM10, PM102, PM103, LAT, LAT2, LAT3, LON, LON2, LON3;
    Button btn_togg;
    TextView CurAdd;

    private GpsInfo gps;

    int count = 0;
    static int num = 0;
    int avg =0 , avg2 =0, avg3 =0, avg4 =0 , avg5 =0, avg6 =0;
    int average_g = 0, average_y = 0, average_b = 0, average_r = 0;
    boolean flag = true;
    double latitude;
    double longitude;
    double latitude2;
    double longitude2;

    private LocationManager locManager;
    Geocoder geoCoder;
    private Location myLocation = null;
    double latPoint = 0;
    double lngPoint = 0;
    float speed = 0;


    private GoogleMap mMap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        myHandler = new Handler();

        Time = (TextView) findViewById(R.id.Time);
        Time2 = (TextView) findViewById(R.id.Time2);
        Time3 = (TextView) findViewById(R.id.Time3);
        CO = (TextView) findViewById(R.id.CO);
        CO2 = (TextView) findViewById(R.id.CO2);
        CO3 = (TextView) findViewById(R.id.CO3);
        SO2 = (TextView) findViewById(R.id.SO2);
        SO22 = (TextView) findViewById(R.id.SO22);
        SO23 = (TextView) findViewById(R.id.SO23);
        NO2 = (TextView) findViewById(R.id.NO2);
        NO22 = (TextView) findViewById(R.id.NO22);
        NO23 = (TextView) findViewById(R.id.NO23);
        O3 = (TextView) findViewById(R.id.O3);
        O32 = (TextView) findViewById(R.id.O32);
        O33 = (TextView) findViewById(R.id.O33);
        PM2 = (TextView) findViewById(R.id.PM2);
        PM22 = (TextView) findViewById(R.id.PM22);
        PM23 = (TextView) findViewById(R.id.PM23);
        PM10 = (TextView) findViewById(R.id.PM10);
        PM102 = (TextView) findViewById(R.id.PM102);
        PM103 = (TextView) findViewById(R.id.PM103);

        btn_togg = (Button)findViewById(R.id.btn_togg);
        CurAdd = (TextView) findViewById(R.id.curAdd);

        locManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
      //  locManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 1000, 5, this);
        //  locManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER), 1000, 5, this);

        geoCoder = new Geocoder(this, Locale.ENGLISH);


        TimeThread timerThread = new TimeThread();
        timerThread.start();

        final ToggleButton tb = (ToggleButton)this.findViewById(R.id.btn_togg);
        tb.setBackgroundColor(Color.RED);
        tb.setTextColor(Color.WHITE);
        tb.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                if (tb.isChecked()) {
                    flag = false;
                    count = 0;
                    tb.setBackgroundColor(Color.BLUE);
                    tb.setTextColor(Color.WHITE);
                } else {
                    flag = true;
                    TimeThread timerThread = new TimeThread();
                    timerThread.start();
                    tb.setBackgroundColor(Color.RED);

                }
            }
        });

    }//onCreate

    public int random() {
        int ran1 = (int) (Math.random() * 100) + 1;
        return ran1;
    }

    static double round(double d, int n) {
        return Math.round(d * Math.pow(10, n)) / Math.pow(10, n);
    }


    public int average1(int a, int b, int c, int d, int e, int f){
        int gr = 0;
        if(a<25) gr++;
        if(b<25) gr++;
        if(c<25) gr++;
        if(d<25) gr++;
        if(e<25) gr++;
        if(f<25) gr++;

        return gr;
    }


    public int average2(int a, int b, int c, int d, int e, int f){
        int ye = 0;
        if(a>24 && a<50) ye++;
        if(b>24 && b<50) ye++;
        if(c>24 && c<50) ye++;
        if(d>24 && d<50) ye++;
        if(e>24 && e<50) ye++;
        if(f>24 && f<50) ye++;

        return ye;
    }


    public int average3(int a, int b, int c, int d, int e, int f){
        int bl = 0;
        if(a>49 && a<75) bl++;
        if(b>49 && b<75) bl++;
        if(c>49 && c<75) bl++;
        if(d>49 && d<75) bl++;
        if(e>49 && e<75) bl++;
        if(f>49 && f<75) bl++;

        return bl;
    }

    public int average4(int a, int b, int c, int d, int e, int f){
        int rd = 0;
        if(a>74&&a<100) rd++;
        if(b>74&&b<100) rd++;
        if(c>74&&c<100) rd++;
        if(d>74&&d<100) rd++;
        if(e>74&&e<100) rd++;
        if(f>74&&f<100) rd++;

        return rd;
    }

    //Change TextColor , input data : each TextView ex) CO, NO....
    public TextView textColor(TextView txt){
        if(Integer.parseInt(txt.getText().toString())>=0 && Integer.parseInt(txt.getText().toString())<25)
        {
            txt.setTextColor(Color.GREEN);
        }
        else if(Integer.parseInt(txt.getText().toString())>=25 && Integer.parseInt(txt.getText().toString()) < 50)
        {
            txt.setTextColor(Color.YELLOW);
        }
        else if(Integer.parseInt(txt.getText().toString())>=50 && Integer.parseInt(txt.getText().toString()) <  75)
        {
            txt.setTextColor(Color.BLUE);
        }
        else
            txt.setTextColor(Color.RED);
        return txt;
    }

    class TimeThread extends Thread {

        @Override

        public void run() {

            super.run();

            while (flag) {
                try {
                    sleep(3000);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }

                myHandler.post(new Runnable() {
                    @Override

                    public void run() {
                        // TODO Auto-generated method stub
                        if (count > 0) {
                            if (count > 1) {
                                Time3.setText(Time2.getText().toString());
                                CO3.setText(CO2.getText().toString());
                                NO23.setText(NO22.getText().toString());
                                SO23.setText(SO22.getText().toString());
                                O33.setText(O32.getText().toString());
                                PM23.setText(PM22.getText().toString());
                                PM103.setText(PM102.getText().toString());   //셋째줄


                                gps = new GpsInfo(MapsActivity.this);

                                if (gps.isGetLocation()) {

                                    latitude2 = round(Double.parseDouble(String.valueOf(gps.getLatitude())), 3);
                                    longitude2 = round(Double.parseDouble(String.valueOf(gps.getLongitude())), 3);



                                } else {
                                    // GPS 를 사용할수 없으므로
                                    gps.showSettingsAlert();
                                }
                                textColor(CO3);
                                textColor(NO23);
                                textColor(SO23);
                                textColor(O33);
                                textColor(PM23);
                                textColor(PM103);
                            }

                            Time2.setText(Time.getText().toString());
                            CO2.setText(CO.getText().toString());
                            NO22.setText(NO2.getText().toString());
                            SO22.setText(SO2.getText().toString());
                            O32.setText(O3.getText().toString());
                            PM22.setText(PM2.getText().toString());
                            PM102.setText(PM10.getText().toString());

                            gps = new GpsInfo(MapsActivity.this);

                            if (gps.isGetLocation()) {

                                latitude2 = round(Double.parseDouble(String.valueOf(gps.getLatitude())), 3);
                                longitude2 = round(Double.parseDouble(String.valueOf(gps.getLongitude())), 3);


                            } else {
                                // GPS 를 사용할수 없으므로
                                gps.showSettingsAlert();
                            }

                            textColor(CO2);
                            textColor(NO22);
                            textColor(SO22);
                            textColor(O32);
                            textColor(PM22);
                            textColor(PM102);

                        } // count > 0

                        gps = new GpsInfo(MapsActivity.this);

                        if (gps.isGetLocation()) {

                            latitude = round(Double.parseDouble(String.valueOf(gps.getLatitude())), 3);
                            longitude = round(Double.parseDouble(String.valueOf(gps.getLongitude())), 3);

                           // onMapReady(mMap);

                        } else {
                            // GPS 를 사용할수 없으므로
                            gps.showSettingsAlert();
                        }


                        Log.d("location", "button pressed");

                        if(flag == true) {

                            StringBuffer juso = new StringBuffer();
                            Time.setText(getMyCurrentTime());
                            CO.setText(String.valueOf(random()));
                            NO2.setText(String.valueOf(random()));
                            SO2.setText(String.valueOf(random()));
                            O3.setText(String.valueOf(random()));
                            PM2.setText(String.valueOf(random()));
                            PM10.setText(String.valueOf(random()));     //처음값 찍어줌 row1

                            try {
                                // 위도,경도를 이용하여 현재 위치의 주소를 가져온다.
                                List<Address> addresses;
                                addresses = geoCoder.getFromLocation(latitude, longitude, 1);
                                for(Address addr: addresses){
                                    int index = addr.getMaxAddressLineIndex();
                                    for(int i=0;i<=index;i++){
                                        juso.append(addr.getAddressLine(i));
                                        juso.append(" ");
                                    }
                                }

                                CurAdd.setText(String.valueOf(juso));
                            } catch (IOException e) {
                                e.printStackTrace();
                            }
                            textColor(CO);
                            textColor(NO2);
                            textColor(SO2);
                            textColor(O3);
                            textColor(PM2);
                            textColor(PM10);

                            avg = Integer.parseInt(CO.getText().toString());
                            avg2 = Integer.parseInt(NO2.getText().toString());
                            avg3 = Integer.parseInt(SO2.getText().toString());
                            avg4 = Integer.parseInt(O3.getText().toString());
                            avg5 = Integer.parseInt(PM2.getText().toString());
                            avg6 = Integer.parseInt(PM10.getText().toString());


                            average_g = average1(avg, avg2, avg3, avg4, avg5, avg6);
                            average_y = average2(avg, avg2, avg3, avg4, avg5, avg6);
                            average_b = average3(avg, avg2, avg3, avg4, avg5, avg6);
                            average_r = average4(avg, avg2, avg3, avg4, avg5, avg6);


                            if(average_g > 3){
                                num = 1;onMapReady(mMap);
                                //Toast.makeText(MapsActivity.this, "marker : Green", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_g == 3){
                                if(average_y == 3){
                                    num = 2;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Yellow", Toast.LENGTH_SHORT).show();
                                }
                                else if(average_b == 3){
                                    num = 3;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Blue", Toast.LENGTH_SHORT).show();
                                }
                                else if(average_r == 3){
                                    num = 4;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                }
                                else
                                    num = 1;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Green", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_y > 3){
                                num = 2;onMapReady(mMap);
                                //Toast.makeText(MapsActivity.this, "marker : Yellow", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_y == 3){
                                if(average_b == 3){
                                    num = 3;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Blue", Toast.LENGTH_SHORT).show();
                                }
                                else if(average_r == 3){
                                    num = 4;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                }else num = 2;onMapReady(mMap);
                                      //Toast.makeText(MapsActivity.this, "marker : Yellow", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_b > 3){
                                num = 3;onMapReady(mMap);
                                //Toast.makeText(MapsActivity.this, "marker : Blue", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_b == 3){
                                if(average_r == 3){
                                    num = 4;onMapReady(mMap);
                                    //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                }else num = 3;onMapReady(mMap);
                                       //Toast.makeText(MapsActivity.this, "marker : Blue", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_r > 3){
                                num = 4;onMapReady(mMap);
                                //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_r == 3){
                                num = 4;onMapReady(mMap);
                                //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show(); // 3, 3 과 3보다 클때 정의
                            }// 이밑으로 2: 2: 2 정의
                            else if(average_g == 2){
                                if(average_y == 2){
                                    if(average_b == 2) {
                                        num = 3;onMapReady(mMap);
                                        //Toast.makeText(MapsActivity.this, "marker : Blue", Toast.LENGTH_SHORT).show();
                                    }
                                    else if(average_r == 2){
                                        num = 4;onMapReady(mMap);
                                        //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                    }
                                    else num = 2;onMapReady(mMap); //Toast.makeText(MapsActivity.this, "marker : Yellow", Toast.LENGTH_SHORT).show();
                                }
                                else if(average_b == 2){
                                    if(average_r == 2) num = 4;onMapReady(mMap); //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                }
                                else if(average_r == 2) num = 4;onMapReady(mMap); //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_y == 2){
                                if(average_b == 2){
                                    if(average_r == 2){
                                        num = 4;onMapReady(mMap);
                                        //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                    }
                                    else
                                        num = 3;onMapReady(mMap);//Toast.makeText(MapsActivity.this, "marker : Blue", Toast.LENGTH_SHORT).show();
                                }
                                else if(average_r == 2){
                                    num = 4;onMapReady(mMap); //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                }
                            }
                            else if(average_b == 2){
                                if(average_r == 2){
                                    num = 4;onMapReady(mMap); //Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                                }
                                else num = 4;onMapReady(mMap);//Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                            }
                            else if(average_r == 2){
                                num = 4;onMapReady(mMap);//Toast.makeText(MapsActivity.this, "marker : Red", Toast.LENGTH_SHORT).show();
                            }

                        }
                        count++;
                    }
                });//runnable
            }//while
        }//run
    }//End TimeThread


    public String getMyCurrentTime() {

        long now = System.currentTimeMillis();

        Date date = new Date();
        SimpleDateFormat CurTimeFormat = new SimpleDateFormat("HH:mm:ss");
        String strCurTime = CurTimeFormat.format(date);

        return strCurTime;
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
        mMap.clear();

        // Add a marker in Sydney and move the camera
        LatLng sydney = new LatLng(latitude, longitude);

        //mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(sydney,17));
        if(num == 1){
            mMap.addMarker(new MarkerOptions().position(sydney).title("Current location").icon(BitmapDescriptorFactory.
                    fromResource(R.drawable.marker_green)));
            mMap.addCircle(new CircleOptions().center(new LatLng(latitude, longitude)).radius(100).strokeColor(0x222F9D27).fillColor(0x11FFE400));
            //addCircle(sydney, 5);
        }else if(num == 2){
            mMap.addMarker(new MarkerOptions().position(sydney).title("Current location").icon(BitmapDescriptorFactory.
                    fromResource(R.drawable.marker_yellow)));
            mMap.addCircle(new CircleOptions().center(new LatLng(latitude, longitude)).radius(100).strokeColor(0x22FFBB00).fillColor(0x11FFE400));
            //addCircle(sydney, 5);
        }else if(num == 3){
            mMap.addMarker(new MarkerOptions().position(sydney).title("Current location").icon(BitmapDescriptorFactory.
                    fromResource(R.drawable.marker_blue)));
            mMap.addCircle(new CircleOptions().center(new LatLng(latitude, longitude)).radius(100).strokeColor(0x220000FF).fillColor(0x110000ff));
           // addCircle(sydney, 5);
        }else if(num == 4){
            mMap.addMarker(new MarkerOptions().position(sydney).title("Current location").icon(BitmapDescriptorFactory.
                    fromResource(R.drawable.marker_red)));
            mMap.addCircle(new CircleOptions().center(new LatLng(latitude, longitude)).radius(100).strokeColor(0x22980000).fillColor(0x11ff0000));
          //  addCircle(sydney, 5);
        }else Toast.makeText(MapsActivity.this, "잘못된 값입니다", Toast.LENGTH_SHORT);

       // mMap.addMarker(new MarkerOptions().position(sydney).title("Current location"));
        mMap.moveCamera(CameraUpdateFactory.newLatLng(sydney));

        // CameraUpdate camera = CameraUpdateFactory.newLatLngZoom(sydney, 18.5f);
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(sydney,17));

    }
}
