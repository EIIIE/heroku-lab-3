import java.util.HashMap;


public class UserData extends HashMap<String, String> {

    public static final String USERNAME = "username";
    public static final String LOGIN_TIME = "logintime";

    // Конструктор
    public UserData(String username, String logintime) {
        super.put(USERNAME, username);
        super.put(LOGIN_TIME, logintime);
    }

}
