import React from 'react'
import { Text, View } from 'react-native'
import ButtonPrimary from './ButtonPrimary'

function SuccessMsg() {
  return (
    <View>
        <Text>Congratulations!</Text>
        <Text>Your order has been received and its been processed</Text>
        <Text>Please feel free to contact us for any additional enqueries</Text>
        <Text>+255 7837334</Text>
        <ButtonPrimary btnTxt={"Place Another Order"}/>
    </View>
  )
}

export default SuccessMsg