import React from "react";
import { StyleSheet, Text, TouchableOpacity, View } from "react-native";
import { AntDesign } from "@expo/vector-icons";

function ScreenHeader({ onBackPress, header, children, layoutHeight, isBackPress, notBackPressIcon}) {
  return (
    <View>
      <View
        style={{
          backgroundColor: "white",
          height: layoutHeight,
          justifyContent: "space-between",
          padding: 15,
          flexDirection: "row",
        }}
      >
        <TouchableOpacity style={styles.backBtnArrow} onPress={onBackPress}>
          {isBackPress ? <AntDesign name="arrowleft" size={20} color="black" /> : <AntDesign name={notBackPressIcon} size={20} color="black" />}
        </TouchableOpacity>
        <Text style={styles.header}>{header}</Text>
        <View>{children}</View>
      </View>
    </View>
  );
}
const styles = StyleSheet.create({
  header: {
    fontSize: 20,
    fontWeight: "600",
  },
  backBtnArrow: {
    justifyContent:"center",
    alignItems:"center",
    borderRadius:10,
    backgroundColor: "#f2f2f2",
    height:40,
    width:40
  },
  cartBtnWrapper: {
    width: 60,
    height: 30,
    justifyContent: "center",
    alignItems: "center",
  },
});
export default ScreenHeader;
