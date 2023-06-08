import React from 'react'
import { FlatList, StyleSheet, Text, TouchableOpacity, View } from 'react-native'

export default function GridList({numColumns, data}) {
  return (
    <View>
         <FlatList
          data={data}
          numColumns={numColumns}
          keyExtractor={(item) => item.id}
          renderItem={({ item }) => (
           <TouchableOpacity style={styles.productMainBtn} onPress={()=>onAddToCart(item)}>
             <View style={styles.productContainer} >
              <Text style={styles.item}>{item.name}</Text>
              <Text style={styles.itemSubText}>TSH{item.price}</Text>
            </View>
           </TouchableOpacity>
          )}
        />
    </View>
  )
}

const styles = StyleSheet.create({
    mainBtn:{
      width:'50%'
    },
    container: {
      padding: 10,
      width: "100%",
      height:150,
      borderWidth: 4,
      borderColor: "white",
      flexDirection: "column",
      justifyContent: "space-between",
      backgroundColor:"#ccc"
    },
    item: {
      fontWeight: "bold",
      fontSize: 18,
    },
    itemSubText: {
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
