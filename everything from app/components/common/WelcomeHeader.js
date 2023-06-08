import React, { useEffect } from "react";
import { View, Text, Image, StyleSheet, TouchableOpacity } from "react-native";

const WelcomeHeader = ({
  name,
  image,
  msg,
  onItemPressed,
  cartQnty,
  onCartItemPress,
  isLoggedIn,
  onLogoutPressed
}) => {
  useEffect(() => {
    console.log(isLoggedIn);

  }, [])
  
  return (
    <View style={styles.headerContainer}>
      <Image source={image} style={styles.headerImage} />
      <View style={styles.headerTxtWrapper}>
        <Text style={styles.headerText}>Hi, {name}</Text>
        <Text style={styles.subHeaderText}>{msg}</Text>
      </View>
      <View style={styles.menuWrapper}>
        <View style={styles.cartBubleWrapper}>
          <TouchableOpacity onPress={onCartItemPress}>
            <View>
              <Text style={styles.cartBuble}>{cartQnty}</Text>
            </View>
            <Image
              source={require("../../../assets/img/bag.png")}
              style={{ width: 20, height: 20 }}
            />
          </TouchableOpacity>
        </View>
        {!isLoggedIn ? (
          <TouchableOpacity
            style={styles.loginBtnWrapper}
            onPress={onItemPressed}
          >
            <Text>Login</Text>
          </TouchableOpacity>
        ) : (
          <TouchableOpacity
            style={styles.loginBtnWrapper}
            onPress={onLogoutPressed}
          >
            <Text>Logout</Text>
          </TouchableOpacity>
        )}
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  headerContainer: {
    padding: 10,
    height: 70,
    alignItems: "center",
    flexDirection: "row",
  },
  headerImage: {
    width: 40,
    height: 40,
    borderRadius: 25,
    marginRight: 10,
  },
  headerTxtWrapper: {
    flex: 1,
    flexDirection: "column",
  },
  headerText: {
    fontSize: 14,
  },
  subHeaderText: {
    fontSize: 20,
    fontWeight: "bold",
  },
  menuWrapper: {
    flexDirection: "row",
  },
  loginBtnWrapper: {
    marginLeft: 10,
    width: 60,
    height: 40,
    backgroundColor: "white",
    borderRadius: 10,
    justifyContent: "center",
    alignItems: "center",
  },
  cartBubleWrapper: {
    backgroundColor: "#fff",
    width: 50,
    height: 40,
    textAlign: "center",
    justifyContent: "center",
    alignItems: "center",
    borderRadius: 10,
  },
  cartBuble: {
    backgroundColor: "#ff6534",
    justifyContent: "center",
    alignItems: "center",
    textAlign: "center",
    height: 14,
    width: 14,
    lineHeight: 15,
    fontSize: 10,
    borderRadius: 50,
    color: "#fff",
    fontSize: 8,
  },
});

export default WelcomeHeader;
