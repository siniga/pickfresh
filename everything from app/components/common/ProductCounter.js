import React, { useEffect, useState } from "react";
import {
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";
import { AntDesign } from "@expo/vector-icons";

function ProductCounter({ resetQnty, setTotalQuantity, totalQuantity, setCountedItem, item }) {
  const [quantity, setQuantity] = useState(1);

  useEffect(() => {
    if (totalQuantity > 1) {
      setQuantity(totalQuantity);
      return;
    } else {
      setQuantity(1);
    }

  }, [resetQnty, totalQuantity]);

  useEffect(() => {
    setTotalQuantity(quantity);
    setCountedItem(item)
    
  }, [quantity]);

  const handleIncrement = () => {
    setQuantity((prevQuantity) => prevQuantity + 1);
  };

  const handleDecrement = () => {
    if (quantity > 1) {
      setQuantity((prevQuantity) => prevQuantity - 1);
    }
  };

  return (
    <View>
      <View style={styles.quantityContainer}>
        <TouchableOpacity
          style={styles.quantityButtonMinus}
          onPress={handleDecrement}
        >
           <AntDesign name="minus" size={20} color="white" />
        </TouchableOpacity>
        <TextInput
          style={styles.quantityInput}
          keyboardType="numeric"
          value={quantity.toString()}
          onChangeText={(text) => setQuantity(text)}
        />
        <TouchableOpacity
          style={styles.quantityButtonPlus}
          onPress={handleIncrement}
        >
          <AntDesign name="plus" size={20} color="white" />
        </TouchableOpacity>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  quantityContainer: {
    marginTop: 5,
    flex: 1,
    flexDirection: "row",
  },
  quantityText: {
    fontWeight: "bold",
    fontSize: 18,
  },
  quantityInput: {
    padding: 5,
    width: 40,
    height: 40,
    textAlign: "center",
    fontSize: 20,
  },
  quantityButtonMinus: {
    borderRadius: 10,
    backgroundColor: "black",
    width: 40,
    height: 40,
    justifyContent: "center",
    alignItems: "center",
  },
  quantityButtonPlus: {
    borderRadius: 10,
    backgroundColor: "black",
    width: 40,
    height: 40,
    justifyContent: "center",
    alignItems: "center",
  },
  totalAmountWrapper: {
    flex: 0.6,
  },
});
export default ProductCounter;
