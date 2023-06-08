import AsyncStorage from "@react-native-async-storage/async-storage";
import React, { useEffect, useState } from "react";
import {
  FlatList,
  Image,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";
import ButtonPrimary from "../../components/common/ButtonPrimary";
import ProductCounter from "../../components/common/ProductCounter";
import ScreenHeader from "../../components/common/ScreenHeader";
import { StorageUrl } from "../../components/settings/BaseUrl";
import { AntDesign } from "@expo/vector-icons";

function CartScreen({ navigation }) {
  const [cartData, setCartData] = useState([]);
  const [totalQuantity, setTotalQuantity] = useState(1);
  const [countedItem, setCountedItem] = useState({});
  const [cartTotalQuantity, setCartTotalQuantity] = useState(0);
  const [cartTotalAmount, setCartTotalAmount] = useState(0);

  useEffect(() => {
    try {
      AsyncStorage.getItem("cart_data")
        .then((value) => {
          if (value != null) {
            setCartData(JSON.parse(value));
            updateCartTotals();
          }
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error");
      // error reading value
    }
  }, []);

  useEffect(() => {
    updateCartData(cartData);
  }, [totalQuantity]);

  useEffect(() => {
    //update totals quantity and amounts everytime cart data changes
    updateCartTotals();
  }, [cartData]);

  const updateCartData = (Array) => {
    let updatedArray = Array.map((obj) => {
      // Check if"
      if (obj.id === countedItem.id) {
        // Return a new object
        return { ...obj, quantity: totalQuantity };
      }

      return obj;
    });

    setCartData(updatedArray);
  };

  const updateCartTotals = () => {
    getTotalCount();
    getTotalCartAmnt();
  };

  const onScreenCancel = () => {
    //update cart in localstorage
    AsyncStorage.setItem("cart_data", JSON.stringify(cartData));

    //navigate back to home
    navigation.navigate("Home");
  };
  const onCheckoutPress = () => {
    //update cart in localstorage
    AsyncStorage.setItem("cart_data", JSON.stringify(cartData));

    //ncheck if user is already logged in 
    //if yes redirect them to checkout
    //if not redirect them to login
    try {
      AsyncStorage.getItem("auth_token")
        .then((value) => {
          if(value !== null){
            navigation.navigate("Checkout");
            return;
          }

          navigation.navigate("Login", { isFromHomeScreen: false });
         
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error" + e);
      // error reading value
    }
  };
  const onDeleteAll = (deleteItem) => {
    //clear cached cart data
    AsyncStorage.removeItem("cart_data");

    //empty cart array
    setCartData([]);
  };

  const onDeleteItem = (deleteItem) => {
    const newItems = cartData.filter((item) => item.id !== deleteItem.id);
    setCartData(newItems);
    AsyncStorage.setItem("cart_data", JSON.stringify(newItems));
  };

  const getTotalCartAmnt = () => {
    setCartTotalAmount(
      cartData.reduce((total, item) => total + item.price * item.quantity, 0)
    );
  };
  const getTotalCount = () => {
    setCartTotalQuantity(
      cartData.reduce((count, item) => count + item.quantity, 0)
    );
  };

  return (
    <View style={{ flex: 1}}>
      <ScreenHeader
        onBackPress={onScreenCancel}
        header={"My Cart"}
        rightItem={""}
        isBackPress={false}
        notBackPressIcon={"close"}
      >
        <TouchableOpacity
          onPress={onDeleteAll}
          style={{
            justifyContent: "center",
            alignItems: "center",
            borderRadius: 10,
            backgroundColor: "#f2f2f2",
            height: 40,
            width: 40,
          }}
        >
          <AntDesign name="delete" size={20} color="black" />
        </TouchableOpacity>
      </ScreenHeader>
      <View style={{backgroundColor: "white", flex:1, paddingBottom:10}}>
        <FlatList
          showsVerticalScrollIndicator={false}
          style={{ marginTop: 0,paddingBottom:180}}
          data={cartData}
          keyExtractor={(item, index) => index}
          ItemSeparatorComponent={() => <View style={{ height: 15 }} />}
          renderItem={({ index, item }) => (
            <View
              style={{
                width: "100%",
                position: "relative",
                padding: 15,
                borderRadius: 15,
                marginLeft: 5,
              }}
            >
              <TouchableOpacity>
                <View style={styles.productWrapper}>
                  <View style={styles.productImgWrapper}>
                    <Image
                      style={{ with: 100, height: 100 }}
                      source={{ uri: StorageUrl(item.img) }}
                    />
                  </View>
                  <View style={styles.productDetails}>
                    <View>
                      <Text>{item.unit}</Text>
                      <Text style={styles.productName}>
                        {item.name} {item.category}
                      </Text>
                      <Text style={styles.productPrice}>
                        TSH {item.price * item.quantity}
                      </Text>
                    </View>
                    <View style={styles.counterWrapper}>
                      <ProductCounter
                        setTotalQuantity={setTotalQuantity}
                        totalQuantity={item.quantity}
                        setCountedItem={setCountedItem}
                        item={item}
                      />
                      <TouchableOpacity
                        style={styles.deleteWrapper}
                        onPress={() => onDeleteItem(item)}
                      >
                        <Text>Delete</Text>
                      </TouchableOpacity>
                    </View>
                  </View>
                </View>
              </TouchableOpacity>
            </View>
          )}
        />

        <View
          style={{
            position: "absolute",
            bottom: 0,
            height: 160,
            width: "100%",
            borderWidth: 1,
            borderColor: "#ccc",
            backgroundColor: "white",
            borderTopLeftRadius: 30,
            borderTopRightRadius: 30,
            padding: 20,
       
          }}
        >
          <View style={styles.checkoutWrapper}>
            <View style={styles.checkoutViewItem}>
              <Text style={styles.checkoutItemHeader}>Delivery</Text>
              <Text style={styles.checkoutItemDesc}>Free</Text>
            </View>
            {/* <View style={styles.checkoutViewItem}>
              <Text style={styles.checkoutItemHeader}>Total Quantity</Text>
              <Text style={styles.checkoutItemDesc}>+{cartTotalQuantity}</Text>
            </View> */}
            <View style={styles.checkoutViewItem}>
              <Text style={styles.checkoutItemHeader}>Total Amount</Text>
              <Text style={styles.checkoutItemDesc}>TSH {cartTotalAmount}</Text>
            </View>
          </View>
          <View style={{ marginTop: 10 }}>
            <ButtonPrimary
              navigation={navigation}
              linkTo={"Checkout"}
              btnTxt={"Checkout"}
              fetchApiData={onCheckoutPress}
            />
          </View>
        </View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  productWrapper: {
    width: "100%",
    minHeight: 100,
    flexDirection: "row",
    padding: 0,
  },
  productImgWrapper: {
    justifyContent: "center",
    alignContent: "center",
    width: 100,
    height: 130,
    borderRadius: 20,
    padding: 10,
    // borderWidth: 1,
    backgroundColor: "#f5f1ef",
    // borderColor: "#ccc",
  },
  productDetails: {
    marginLeft: 30,
    justifyContent: "space-between",
  },
  productName: {
    fontSize: 18,
    fontWeight: "600",
  },
  productPrice: {
    fontSize: 16,
    fontWeight: "500",
  },
  counterWrapper: {
    width: "71%",
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
  },
  deleteWrapper: {},
  checkoutWrapper: {},
  checkoutViewItem: {
    flexDirection: "row",
    justifyContent: "space-between",
  },
  checkoutItemHeader: {
    color: "#666",
    fontSize: 18,
    marginTop: 5,
  },
  checkoutItemDesc: {
    color: "#666",
    fontSize: 18,
    marginTop: 5,
  },
});
export default CartScreen;
