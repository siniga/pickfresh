import React from "react";
import { StyleSheet, Text, TouchableOpacity, View } from "react-native";

function ButtonPrimary({ navigation, btnTxt, linkTo,flag, style, fetchApiData }) {
    //flag detarmine what action should be taken when button is pressed
  const onButtonPress = () => {
    if(flag == "navigate"){
        navigation.navigate(linkTo);
    }else{
        fetchApiData();
    }
  };
  return (
    <View style={style}>
      <TouchableOpacity style={styles.checkoutBtn} onPress={onButtonPress}>
        <Text style={styles.checkoutBtnTxt}>{btnTxt}</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  checkoutBtn: {
    marginTop: 0,
    backgroundColor: "#ff6534",
    alignItems: "center",
    justifyContent: "center",
    padding: 15,
    borderRadius: 20,
  },
  checkoutBtnTxt: {
    fontSize: 20,
    fontWeight: "700",
    color: "white",
  },
});
export default ButtonPrimary;
