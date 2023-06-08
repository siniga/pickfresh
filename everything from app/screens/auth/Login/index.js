import React, { useState } from "react";
import { useNavigation } from "@react-navigation/native";
import AsyncStorage from "@react-native-async-storage/async-storage";
import {
  View,
  TextInput,
  Text,
  TouchableOpacity,
  StyleSheet,
  ActivityIndicator,
} from "react-native";
import { PostData } from "../../../components/api/PostData";
import ButtonPrimary from "../../../components/common/ButtonPrimary";
import { FetchData } from "../../../components/api/FetchData";
import { user } from "../../../components/settings/User";
import { BaseUrl } from "../../../components/settings/BaseUrl";

const LoginScreen = ({ navigation, route }) => {
  const [phone, setPhone] = useState("0768665433");
  const [password, setPassword] = useState("123456");
  const [animating, setAnimating] = useState(false);
  const { isFromHomeScreen } = route.params;

  const logUserIn = () => {
    //TODO:input validation from chatgpt
    setAnimating(true)
    PostData(BaseUrl("login"), { phone, password })
      .then((response) => {
        AsyncStorage.setItem("auth_token", response.token);
        AsyncStorage.setItem("user", JSON.stringify(response.user));
        setAnimating(false)

        //fetch business that belong to this user
        fetchUserBusiness(response.user.id);
      })
      .catch((err) => {
        setAnimating(false)
        console.log(err);
      });
  };


  const fetchUserBusiness = (userId) => {
    FetchData(BaseUrl(`user/${userId}/business`))
      .then((response) => {
        if (response)
          if (isFromHomeScreen) {
            //check if user is from home
            //if yes redirect back to home screen after loging
            //esle redirect to checkout screen
            navigation.navigate("Home");
          } else {
            navigation.navigate("Checkout");
          }

        console.log(response);
      })
      .catch((err) => {
        console.log(err);
      });
  };

  const onRegisterLinkPress = ()=>{
    navigation.navigate("Register",{isFromHomeScreen: true})
  }
  return (
    <View style={styles.container}>
      {animating && (
        <ActivityIndicator
          animating={animating}
          color="white"
          size="large"
          style={styles.activityIndicator}
        />
      )}
      <Text style={styles.title}>Welcome back</Text>
      <TextInput
        style={styles.input}
        placeholder="Phone number"
        value={phone}
        onChangeText={(text) => setPhone(text)}
      />
      <TextInput
        style={styles.input}
        placeholder="Password"
        secureTextEntry={true}
        value={password}
        onChangeText={(text) => setPassword(text)}
      />
      <ButtonPrimary
        style={{ width: "80%", marginTop: 0 }}
        navigation={navigation}
        linkTo={"Home"}
        btnTxt={"Login"}
        flag={"fetchData"}
        fetchApiData={logUserIn}
      />

      <View style={styles.registerLinkWrapper}>
        <Text style={styles.registerLinkTitle}>
          If you dont have an account
        </Text>
        <TouchableOpacity onPress={onRegisterLinkPress}>
          <Text style={styles.registerLink}>Register</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: "#fff",
  },
  activityIndicator: {
    position: "absolute",
    width: "100%",
    backgroundColor: "rgba(52, 52, 52, 0.8)",
    zIndex: 99,
    height: "100%",
  },
  title: {
    fontSize: 30,
    marginBottom: 20,
  },
  input: {
    width: "80%",
    height: 50,
    borderColor: "#ddd",
    borderWidth: 1,
    padding: 15,
    borderRadius: 10,
    marginBottom: 30,
    backgroundColor: "#eee",
    fontSize: 18,
  },
  registerLinkWrapper: {
    flexDirection: "row",
    marginTop: 20,
  },
  registerLinkTitle: {},
  registerLink: {
    color: "blue",
    fontSize: 16,
    marginLeft: 6,
  },
});

export default LoginScreen;
