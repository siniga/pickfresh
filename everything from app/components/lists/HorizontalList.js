import React, { useEffect, useState } from 'react';
import { View, Text, FlatList, StyleSheet, TouchableOpacity } from 'react-native';

const HorizontalList = ({ data, onItemSelect }) => {
  const [active, setActive] = useState(0);
  const onPressBtn = (item) =>{
     onItemSelect(item)
     setActive(item.id)
  }
  return (
    <View style={styles.horizontalListContainer}>
      <FlatList
        showsHorizontalScrollIndicator={false}
        data={data}
        horizontal={true}
        renderItem={({ item }) => (
          <TouchableOpacity style={active == item.id ? styles.itemContainerActive : styles.itemContainer} onPress={() =>{
            onPressBtn(item)
          } }>
            <Text style={active == item.id ? styles.itemTextActive :styles.itemText}>{item.name}</Text>
          </TouchableOpacity>
        )}
        keyExtractor={item => item.id.toString()}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  horizontalListContainer: {
    marginTop: 0,
    padding: 2,
  },
  itemContainer: {
    padding: 10,
    margin: 5,
    borderWidth:1,
    borderColor:"#ccc",
    borderRadius: 15,
    minWidth: 90,
    backgroundColor: 'white',
  },
  itemContainerActive:{
    padding: 10,
    margin: 5,
    backgroundColor: '#ff6433',
    borderRadius: 5,
    minWidth: 90,
    borderRadius: 15,
  },
  itemText: {
    fontSize: 16,
    textAlign: 'center',
  },
  itemTextActive:{
    color:"white",
    fontSize: 16,
    textAlign: 'center',
  }
});

export default HorizontalList;