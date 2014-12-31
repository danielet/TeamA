package reader.bluetooth;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;


import android.os.Bundle;

import android.os.Handler;
import android.os.Message;


import android.util.Log;
import android.view.Menu;

import android.app.Activity;
import android.content.BroadcastReceiver;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;

import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;


import java.util.ArrayList;
import java.util.Dictionary;
import java.util.Hashtable;

import java.util.Set;

//import reader.bluetooth.bluetoothConnection;



public class MainActivity extends Activity {

    //LIST OF ARRAY STRINGS WHICH WILL SERVE AS LIST ITEMS
    //DEFINING A STRING ADAPTER WHICH WILL HANDLE THE DATA OF THE LISTVIEW
    private ArrayList<String> listItems     =   new ArrayList<String>();
    private ArrayAdapter<String> adapterList;
    private ListView list;


    //BLUETOOTH
    private  BluetoothAdapter adapterBluetooth = null;
    int REQUEST_ENABLE_BT = 0;


    //LOGIC BLUETOOTH DEVICES
    private int countBluetoothDevice = 0;
    private Dictionary<Integer, BluetoothDevice> bluetoothInfo ;


    private bluetoothConnection connectionThreadBT ;


    private Handler mHandlerBT_Connection;
    private Handler mHandlerCO;

    private TextView connectionLabel;


    private TextView COLabel;
    private TextView O3Label;
    private TextView TempLabel;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        bluetoothInfo       = new Hashtable();
        adapterBluetooth    = BluetoothAdapter.getDefaultAdapter();


        if (adapterBluetooth == null)
            Log.d("MATTEO", "NULL ADAPTER");
        else
            Log.d("MATTEO", "OK ADAPTER");


        //CHECK if bluetooth is enabled
        if (!adapterBluetooth.isEnabled()) {
            Intent enableBtIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
            startActivityForResult(enableBtIntent, REQUEST_ENABLE_BT);
        }


        //LIST
        list = (ListView) findViewById(R.id.listViewBluetooth);
        adapterList=new ArrayAdapter<String>(this,
                android.R.layout.simple_list_item_1,
                listItems);

        list.setAdapter(adapterList);


        list.setClickable(true);
        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {


            @Override
            public void onItemClick(AdapterView<?> arg0, View arg1, int position, long arg3) {
                Object obj = list.getItemAtPosition(position);
                String str = (String) obj;//As you are using Default String Adapter


                Toast.makeText(getApplicationContext(), str, Toast.LENGTH_SHORT).show();
                BluetoothDevice device = bluetoothInfo.get(position);
                //    device.ACTION_BOND_STATE_CHANGED("");



        connectionThreadBT = new bluetoothConnection(device, adapterBluetooth, mHandlerBT_Connection,mHandlerCO );
                connectionThreadBT.start();

            }
        });


        /*
        HANDLER PART MESSAGES FROM BLUETOOTH
         */
        connectionLabel = (TextView)findViewById(R.id.btStatus);

        mHandlerBT_Connection=new Handler(){
            @Override
            public void handleMessage(Message message){


				int s = message.what;

                switch(s)
                {
                    case -1:
                        connectionLabel.setText("CONNECTION REFUSED");
                        break;
                    case 0:
                        connectionLabel.setText("CONNECTING");
                        break;
                    case 1:
                        connectionLabel.setText("CONNECTED");
                        Button btn = (Button) findViewById(R.id.closeConnection);
                        btn.setEnabled(true);
                        adapterList.clear();
                        break;
                }
            }
        };


        COLabel = (TextView)findViewById(R.id.textCO);
        O3Label = (TextView)findViewById(R.id.textViewO3);
        TempLabel = (TextView)findViewById(R.id.textViewTemp);
        mHandlerCO=new Handler(){
            @Override
            public void handleMessage(Message message){
                Bundle data = message.getData();
                COLabel.setText( data.getString("CO"));
                O3Label.setText( data.getString("O3"));
                TempLabel.setText(data.getString("Temp"));
            }
        };



    }


    public void closeConnection(View v)
    {




        Button btn = (Button) findViewById(R.id.closeConnection);
        btn.setEnabled(false);
        TextView connectionLabel = (TextView)findViewById(R.id.btStatus);
        connectionLabel.setText("NO CONNECTED");

        connectionThreadBT.stopConnection();
    }

    public void discoverySensor(View v){

        adapterList.clear();
        if(countBluetoothDevice > 0)
        {
            for(int ii=0; ii<countBluetoothDevice;ii++)
            {
                bluetoothInfo.remove(ii);
            }
        }
        countBluetoothDevice = 0;

        if (adapterBluetooth.isDiscovering()) {
            adapterBluetooth.cancelDiscovery();
            Log.d("MATTEO", "DISCOVERY	STOP");
        }



        Set<BluetoothDevice> pairedDevices = adapterBluetooth.getBondedDevices();
        // If there are paired devices
        if (pairedDevices.size() > 0) {
            // Loop through paired devices
            for (BluetoothDevice device : pairedDevices) {
                // Add the name and address to an array adapter to show in a ListView
                Log.d("MATTEO", "PAIRED: " + device.getName() + "\n" + device.getAddress());
                adapterList.add(device.getName() + "\n" + device.getAddress());

                bluetoothInfo.put(countBluetoothDevice, device);
                countBluetoothDevice++;

            }
        }
        else
        {
            Log.d("MATTEO", "NOPAIRED");
        }


        boolean flagStatus = adapterBluetooth.startDiscovery();
//        // Register the BroadcastReceiver
        IntentFilter filter3 = new IntentFilter(BluetoothDevice.ACTION_FOUND);
        registerReceiver(new DiscoveryFilter(), filter3);
        Log.d("MATTEO", "DISCOVERY START " + flagStatus);
    }


    private class DiscoveryFilter extends BroadcastReceiver {
        public void onReceive(Context context, Intent intent) {
            String action = intent.getAction();
            // When discovery finds a device
            Log.d("MATTEO", "FILTER " );
//            bluetoothInfo.
            if (BluetoothDevice.ACTION_FOUND.equals(action)) {
                // Get the BluetoothDevice object from the Intent
                BluetoothDevice device = intent.getParcelableExtra(BluetoothDevice.EXTRA_DEVICE);
                // Add the name and address to an array adapter to show in a ListView
                adapterList.add(device.getName() + "\n" + device.getAddress());
                bluetoothInfo.put(countBluetoothDevice, device);
                countBluetoothDevice++;

                Log.d("MATTEO", "FILTER "+  device.getAddress());

            }else{
                if(BluetoothAdapter.ACTION_DISCOVERY_FINISHED.equals(action)){
//                    Log.d("MATTEO", "HOW MANY DEVICES? " + mArrayAdapter.size());
                    adapterBluetooth.startDiscovery();
                    Log.d("MATTEO", "RE DISCOVERY " );
                }

            }
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }




}