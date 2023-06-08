import React, { useState } from "react";
import { View, Text, FlatList, StyleSheet, TouchableOpacity } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";
import ListHeader from "../../components/common/ListHeader";
import SearchBar from "../../components/common/SearchBar";

const ProductListScreen = ({navigation}) => {
  const data = [
    { id: 1, name: "Product 1", price: "10" },
    { id: 2, name: "Product 2", price: "20" },
    { id: 3, name: "Product 3", price: "30" },
    { id: 4, name: "Product 4", price: "40" },
    { id: 5, name: "Product 5", price: "50" },
    { id: 6, name: "Product 6", price: "60" },
  ];

  const onAddToCart = (product) => {
    alert(product.name)
    navigation.navigate('CreateCart', { product });
  }

  return (
    <SafeAreaView style={styles.safeContainer}>
      <View style={styles.container}>
        <SearchBar/>

        <ListHeader>Chagua aina ya bidhaa</ListHeader>
        <FlatList
          data={data}
          numColumns={2}
          keyExtractor={(item) => item.id}
          renderItem={({ item }) => (
           <TouchableOpacity style={styles.productMainBtn} onPress={()=>onAddToCart(item)}>
             <View style={styles.productContainer} >
              <Text style={styles.productName}>{item.name}</Text>
              <Text style={styles.productPrice}>TSH{item.price}</Text>
            </View>
           </TouchableOpacity>
          )}
        />
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeContainer: {
    flex: 1,
  },
  container: {
    flex: 1,
    padding:10
  },
  productMainBtn:{
    width:'50%'
  },
  productContainer: {
    padding: 10,
    width: "100%",
    height:150,
    borderWidth: 4,
    borderColor: "white",
    flexDirection: "column",
    justifyContent: "space-between",
    backgroundColor:"#ccc"
  },
  productName: {
    fontWeight: "bold",
    fontSize: 18,
  },
  productPrice: {
    fontSize: 18,
    color: "green",
  },
  grid: {
    flex: 1,
    flexDirection: "row",
    flexWrap: "wrap",
    alignItems: "flex-start",
  },
});

export default ProductListScreen;
