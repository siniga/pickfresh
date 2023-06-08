import React from "react";
import { View, Text, StyleSheet, TouchableOpacity } from "react-native";

function Basic({ item,onPress }) {
  return (
    <View style={styles.itemContainer}>
      <TouchableOpacity onPress={() => onPress(item)}>
        <Text style={styles.itemText}>{item.title}</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  itemContainer: {
    padding: 10,
    margin: 5,
    borderRadius: 5,
  },
  itemText: {
    fontSize: 18,
  },
});

export default Basic;
