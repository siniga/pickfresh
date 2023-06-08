import React from "react";
import {
  FlatList,
  Image,
  StyleSheet,
  Text,
  TouchableOpacity,
  View,
} from "react-native";
import { StorageUrl } from "../settings/BaseUrl";

function HorizontalImgList({ data, onPressBtn }) {
  return (
    <FlatList
      style={{ marginTop: 10 }}
      showsHorizontalScrollIndicator={false}
      data={data}
      horizontal={true}
      renderItem={({ item }) => (
        <View style={styles.topProductsWrapper}>
          {/* only show special products */}
          <TouchableOpacity
            style={{
              width: 80,
              height: 80,
              borderRadius: 100,
              padding: 20,
              backgroundColor: "white",
              alignItems: "center",
              justifyContent: "center",
              borderColor: "#ccc",
              borderWidth: 1,
            }}
            onPress={() => onPressBtn(item)}
          >
            <Image
              resizeMode="contain"
              source={{ uri: StorageUrl(item.img) }}
              style={{ width: 60, height: 60 }}
            />
          </TouchableOpacity>
          <Text>{item.name}</Text>
        </View>
      )}
      keyExtractor={(item) => item.id.toString()}
    />
  );
}

const styles = StyleSheet.create({
  itemContainer: {
    padding: 10,
    margin: 5,
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 15,
    minWidth: 90,
    backgroundColor: "white",
  },
  topProductsWrapper: {
    justifyContent: "space-between",
    alignItems: "center",
    height: 103,
    marginRight: 20,
  },
});
export default HorizontalImgList;
