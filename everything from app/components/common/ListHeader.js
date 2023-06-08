import React from 'react'
import { StyleSheet, Text, View } from 'react-native'

export default function ListHeader({children, style}) {
  return (
    <View style={style  ? style : styles.headerWrapper}>
        <Text style={styles.headerTxt}>{children}</Text>
    </View>
  )
}
const styles = StyleSheet.create({
    headerWrapper: {
        paddingTop: 10,
        paddingBottom:10
    },
    headerTxt: {
      marginTop: 10,
      fontSize: 17,
      fontWeight:"bold",
      fontSize:22,
      color:"#666"
    }
    
  });
