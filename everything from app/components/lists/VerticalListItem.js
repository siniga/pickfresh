import React from 'react'
import { FlatList, TouchableOpacity, View } from 'react-native'
import Basic from '../cards/Basic'

function VerticalListItem({data,onPress, numCol}) {
  return (
   <View>
     <FlatList
        data={data}
        numColumns={numCol}
        renderItem={({ item }) => <Basic item={item} onPress={onPress}/>}
        keyExtractor={(item) => item.id.toString()}
      />
   </View>
  )
}

export default VerticalListItem