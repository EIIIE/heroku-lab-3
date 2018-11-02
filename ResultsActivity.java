import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;


public class ResultsActivity extends AppCompatActivity {


    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_results);

        Intent intent = getIntent();
        String json = intent.getStringExtra("json");

        JSONArray jsonArray = null;

        ListView listView = (ListView) findViewById(R.id.listView);
        ArrayList<UserData> list = new ArrayList<UserData>();

        SimpleDateFormat df = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");

        try {
            jsonArray = new JSONArray(json);

            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject obj = jsonArray.getJSONObject(i);
                long l = Long.parseLong(obj.getString("logintime")) * 1000;
                Date date = new Date(l);
                list.add(new UserData(obj.getString("username"), df.format(date)));
            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

        ListAdapter adapter = new SimpleAdapter(this, list, R.layout.info,
                new String[]{UserData.USERNAME, UserData.LOGIN_TIME},
                new int[]{R.id.info_name, R.id.info_year});
        listView.setAdapter(adapter);
    }

}

