package reader.bluetooth;


import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.lang.reflect.Method;
import java.util.UUID;




/**
 * Created by matteo on 10/1/15.
 * QueueJob Manager
 *
 * QUEUE MANAGER
 */

public class bluetoothConnection extends Thread {

    private BluetoothSocket mmSocket        = null;
    private BluetoothDevice mmDevice        = null;
    private static final UUID BT_UUID       = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");
    private BluetoothAdapter adapter        = null;
    private Handler mConnectionLabel        = null;

    private Handler mConnectionCO        = null;


    private BluetoothSocket sockFallback    = null;




    public bluetoothConnection(BluetoothDevice device, BluetoothAdapter adapter_tmp,
                               Handler connectionLabel, Handler connectionCO) {

        mmDevice                = device;
        adapter                 = adapter_tmp;
       //NECESSARY FOR THE UIss
        mConnectionLabel        = connectionLabel;
        mConnectionCO           = connectionCO;


    }


    public void run() {
        // Cancel discovery because it will slow down the connection
        adapter.cancelDiscovery();

        try {
            // Connect the device through the socket. This will block
            // until it succeeds or throws an exception
            mConnectionLabel.sendEmptyMessage(0);
            Log.d("MATTEO", "CONNECTION " + mmDevice.getAddress() + " " + mmDevice.getName());
            mmSocket = mmDevice.createRfcommSocketToServiceRecord(BT_UUID);

            mmSocket.connect();

        } catch (Exception connectException) {

            Log.e("MATTEO", "There was an error while establishing Bluetooth connection. Falling back..", connectException);
            Class<?> clazz = mmSocket.getRemoteDevice().getClass();
            Class<?>[] paramTypes = new Class<?>[]{Integer.TYPE};
            try {
                Method m = clazz.getMethod("createRfcommSocket", paramTypes);
                Object[] params = new Object[]{Integer.valueOf(1)};
                sockFallback = (BluetoothSocket) m.invoke(mmSocket.getRemoteDevice(), params);
                sockFallback.connect();
                mmSocket = sockFallback;
            } catch (Exception e2) {
                Log.e("MATTEO", "Couldn't fallback while establishing Bluetooth connection. Stopping app..", e2);
//                stopService();
                try {
                    Log.d("MATTEO", "CLOSE " + mmDevice.getAddress() + " " + mmDevice.getName());
                    mmSocket.close();
                } catch (IOException closeException) {
                    Log.d("MATTEO", "CONNECTION CLOSE ERROR " + mmDevice.getAddress() + " " + mmDevice.getName());
                }

            }


        }

        // Do work to manage the connection (in a separate thread)
        InputStream air_pollution;
        if (mmSocket != null) {

            Log.d("MATTEO", "CONNECTED WITH " + mmDevice.getAddress() + " " + mmDevice.getName());
            mConnectionLabel.sendEmptyMessage(1);
            try {
                air_pollution = mmSocket.getInputStream();

                byte[] buffer = new byte[256];  // buffer store for the stream
                int bytes; // bytes returned from read()

                // Keep listening to the InputStream until an exception occurs
                while (true) {
                    Log.d("MATTEO", "waiting for data");
                    try {
                        // Read from the InputStream
                        bytes = air_pollution.read(buffer);        // Get number of bytes and message in "buffer"
                        byte[] readBuf = (byte[]) buffer;
                        String strIncom = new String(readBuf, 0, bytes);


                        String [] ss = strIncom.split(",");
                        Log.d("MATTEO", "Data " + strIncom);
                        Message msg1        = new Message() ;
                        Bundle bb           = new Bundle();
                        bb.putString("CO", ss[0]);
                        bb.putString("O3",ss[1]);
                        bb.putString("Temp",ss[2]);
                        msg1.setData(bb);
                        mConnectionCO.sendMessage(msg1);

                    } catch (IOException e) {
                        break;
                    }
                }
            } catch (IOException e) {
                e.printStackTrace();
                Log.d("MATTEO", "error");
            }

        }
    }

    public void stopConnection()
    {
        try {
            Log.d("MATTEO" ,"CLOSE " + mmDevice.getAddress() + " " +mmDevice.getName() );
            OutputStream cmd = mmSocket.getOutputStream();
            String ss = "CLOSE";
            cmd.write(ss.getBytes());
            mmSocket.close();

        } catch (IOException closeException) {
            Log.d("MATTEO" ,"CONNECTION CLOSE ERROR " + mmDevice.getAddress() + " " +mmDevice.getName() );
        }
    }




}
