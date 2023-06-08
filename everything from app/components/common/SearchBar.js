import React, { useState } from 'react';
import { View, TextInput, StyleSheet } from 'react-native';

const SearchBar = ({ onChangeText }) => {
  return (
    <View style={styles.searchContainer}>
      <TextInput
        style={styles.searchInput}
        placeholder="Search"
        onChangeText={onChangeText}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  searchContainer: {
    marginTop:15,
    borderRadius:13,
    backgroundColor: '#fafafa',
    borderWidth:1,
    borderColor:"#dddddd",
    paddingTop: 2,
    paddingBottom: 2,
    paddingLeft:10,
    margin: 5,
    borderRadius: 5,
  },
  searchInput: {
    fontSize: 18,
    padding: 5,
  },
});

export default SearchBar;
