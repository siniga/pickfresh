import AsyncStorage from "@react-native-async-storage/async-storage";
import React, { useCallback, useEffect, useState } from "react";
import {
  View,
  Text,
  Image,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  FlatList,
  ScrollView,
} from "react-native";
import { FetchData } from "../../components/api/FetchData";
import ProductCounter from "../../components/common/ProductCounter";
import ScreenHeader from "../../components/common/ScreenHeader";
import { BaseUrl, StorageUrl } from "../../components/settings/BaseUrl";
import { AntDesign } from "@expo/vector-icons";
import { BaseMobileUrl } from "../../components/settings/BaseMobileUrl";
import { ActivityIndicator } from "@react-native-material/core";

const AddToCartScreen = ({ route, navigation }) => {
  const [varieties, setVarieties] = useState([]);
  const [varietyId, setVarietyId] = useState();
  const [similarPorducts, setSimilarProducts] = useState([]);
  const [selectedProduct, setSelectedProduct] = useState({});
  const [totalQuantity, setTotalQuantity] = useState(0);
  const [isAddedTocart, setItemIsAddedToCart] = useState(false);
  const [cartQnty, setCartQnty] = useState(0);
  const [countedItem, setCountedItem] = useState();
  const [animating, setAnimating] = useState(false);
  const { product } = route.params;

  useEffect(() => {
    //fetch varieties or skus from fresh business
    FetchData(BaseMobileUrl(`skus/business/22/product/${product.id}`))
      .then((response) => {
        setVarieties(response.skus);

        if (varieties.length > 0) setVarietyId(varieties[0].serverId);
      })
      .catch((err) => {
        console.log(err);
      });
  }, [varieties.length]);

  useEffect(() => {
    setAnimating(true)
    //fetch similar products
    FetchData(BaseMobileUrl(`products/business/22/category/${product.categoryId}/special/0`))
      .then((response) => {
        setSimilarProducts(response.products);
        setAnimating(false)
      })
      .catch((err) => {
        setAnimating(false)
        console.log(err);
      });
  }, [product.categoryId]);

  useEffect(() => {
    setSelectedProduct(product);
  }, [product.id]);

  useEffect(() => {
    //check if selected item is in a cart on the first render
    isItemInCart(product);
  }, []);

  useEffect(() => {
    getCount();
  }, [totalQuantity]);

  let cart = [];
  const onAddToCart = (cartData) => {
    setItemIsAddedToCart(true);
    const { id, name, category, price, unit_id, img } = cartData;

    //check if there is an available cart in local storage
    try {
      AsyncStorage.getItem("cart_data")
        .then((value) => {
          if (value != null) {
            //add item to cart
            cart = JSON.parse(value);
            cart.unshift({
              id: id,
              product_id:id,
              name: name,
              category: category,
              price: price,
              quantity: totalQuantity,
              total_amount: price,
              total_quantity: totalQuantity,
              sku_id: varietyId,
              unit_id: unit_id,
              img: img,
            });
            
          } else {
            //add item to cart
            cart.unshift({
              id: id,
              product_id:id,
              name: name,
              category: category,
              price: price,
              quantity: totalQuantity,
              total_amount: price,
              total_quantity: totalQuantity,
              sku_id: varietyId,
              unit_id: unit_id,
              img: img,
            });
          }
          //store to localstorage
          AsyncStorage.setItem("cart_data", JSON.stringify(cart));

          //update quantity
          getCount();
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error");
      // error reading value
    }
  };

  const onUpdateCart = () => {
    try {
      AsyncStorage.getItem("cart_data")
        .then((value) => {
          if (value != null) updateCartData(JSON.parse(value));

          //update quantity
          getCount();
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error");
      // error reading value
    }
  };

  const updateCartData = (Array) => {
    let updatedArray = Array.map((obj) => {
      // Check if"
      if (obj.id === selectedProduct.id) {
        // Return a new object
        return { ...obj, quantity: totalQuantity };
      }

      return obj;
    });

    AsyncStorage.setItem("cart_data", JSON.stringify(updatedArray));
  };

  const onBackPress = () => {
    navigation.navigate("Home");
  };

  const onViewCart = () => {
    //cache the current product
   // AsyncStorage.setItem("last_selected_product", JSON.stringify(selectedProduct));

    //navigate to cart screen
    navigation.navigate("Cart",  {cart: cart});
  };

  const onSelectVariety = (variety) => {
    setVarietyId(variety.serverId);
  };

  const onSelectSimilarProduct = (product) => {
    //check if selected item is already added to the cart

    isItemInCart(product);
    setSelectedProduct(product);
    setTotalQuantity(1);
  };

  const isItemInCart = (item) => {
    try {
      AsyncStorage.getItem("cart_data")
        .then((value) => {
          if (value != null) {
            setItemIsAddedToCart(false);
            let exist = JSON.parse(value).map((obj) => {
              // Check if product is in the cart
              if (obj.id == item.id) {
                //change add button to add more
                setItemIsAddedToCart(true);

                //set total quantity to quantity of a selected product
                setTotalQuantity(obj.quantity);
                return;
              }
            });
          }
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error");
      // error reading value
    }
  };

  const getCount = () => {
    //check if there is an available cart in local storage
    try {
      AsyncStorage.getItem("cart_data")
        .then((value) => {
          if (value != null) {
            //add item to cart
            cart = JSON.parse(value);
            setCartQnty(cart.reduce((count, item) => count + item.quantity, 0));
          }
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error");
      // error reading value
    }
  };
  return (
    <View style={styles.container}>
      {animating && <ActivityIndicator
          animating={animating}
          color="white"
          size="large"
          style = {styles.activityIndicator}
        /> }
      <ScreenHeader
        onBackPress={onBackPress}
        header={"Add to cart"}
        rightItem={true}
        rightIcon={"minus"}
        layoutHeight={90}
        isBackPress={true}
      >
        <View style={styles.cartBubleWrapper}>
          <TouchableOpacity onPress={onViewCart}>
            <View>
              <Text style={styles.cartBuble}>{cartQnty}</Text>
            </View>
            <Image
              source={require("../../../assets/img/bag.png")}
              style={{ width: 20, height: 20 }}
            />
          </TouchableOpacity>
        </View>
      </ScreenHeader>
      <ScrollView style={styles.scrollView}>
        <View style={styles.topContainer}>
          <Image
            style={styles.productImage}
            source={{ uri: StorageUrl(selectedProduct.img) }}
          />
          <View style={styles.productDetailsContainer}>
            {/* <Text style={styles.productPrice}>${product.price}</Text> */}
          </View>
        </View>
        <View style={styles.centerContainer}>
          <View style={styles.productNameWrapper}>
            <View>
              <Text style={styles.productCategory}>
                {selectedProduct.category}
              </Text>
              <Text style={styles.productName}>{selectedProduct.name}</Text>
            </View>
            <View style={{ marginTop: 45 }}>
              <ProductCounter
                setCountedItem={setCountedItem}
                resetQnty={selectedProduct.id}
                setTotalQuantity={setTotalQuantity}
                totalQuantity={totalQuantity}
              />
            </View>
          </View>
          <View style={styles.descriptionWrapper}>
            <Text style={styles.description}>Variety</Text>
            <FlatList
              showsHorizontalScrollIndicator={false}
              data={varieties}
              horizontal={true}
              keyExtractor={(item) => item.serverId}
              renderItem={({ index, item }) => (
                <TouchableOpacity
                  style={
                    varietyId == item.serverId
                      ? styles.varietyItemWrapperActive
                      : styles.varietyItemWrapper
                  }
                  onPress={() => onSelectVariety(item)}
                >
                  <Text
                    style={
                      varietyId == item.serverId
                        ? styles.varietyItemWrapperTxtActive
                        : styles.varietyItemWrapperTxt
                    }
                  >
                    {item.name}
                  </Text>
                </TouchableOpacity>
              )}
            />
          </View>
          <View style={styles.relatedProductsWrapper}>
            <Text style={styles.relatedProductsHeader}>Similar Products</Text>
            <View>
              <FlatList
                showsHorizontalScrollIndicator={false}
                data={similarPorducts}
                horizontal={true}
                keyExtractor={(item) => item.id}
                renderItem={({ index, item }) => (
                  <TouchableOpacity
                    style={styles.relatedItemImgWrapper}
                    onPress={() => onSelectSimilarProduct(item)}
                  >
                    <Image
                      style={{ width: 50, height: 50 }}
                      source={{ uri: StorageUrl(item.img) }}
                    />
                  </TouchableOpacity>
                )}
              />
            </View>
          </View>
        </View>
        <View style={styles.bottomContainer}>
          <View style={styles.totalAmountWrapper}>
            <Text style={styles.totalAmountHeader}>Total Price</Text>
            <View style={styles.currencyWrapper}>
              <Text style={styles.currency}>TSH </Text>
              <Text style={styles.totalAmount}>
                {totalQuantity * selectedProduct.price}
              </Text>
            </View>
          </View>
          <View style={styles.addToCartButtonWrapper}>
            {isAddedTocart ? (
              <TouchableOpacity
                style={styles.addedToCartButton}
                onPress={() => onUpdateCart(product)}
              >
                <Text style={styles.addToCartButtonText}>Add More</Text>
              </TouchableOpacity>
            ) : (
              <TouchableOpacity
                style={styles.addToCartButton}
                onPress={() => onAddToCart(selectedProduct)}
              >
                <Text style={styles.addToCartButtonText}>Add to Cart</Text>
              </TouchableOpacity>
            )}
          </View>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  activityIndicator: {
    position:"absolute",
    width:"100%",
    backgroundColor:"rgba(52, 52, 52, 0.8)",
    zIndex:99,
    height: "100%"
 },
  scrollView: {
    flex: 1,
  },
  cartBubleWrapper: {
    width: 35,
    height: 40,
    textAlign: "center",
    justifyContent: "center",
    alignItems: "center",
    borderRadius: 10,
  },
  cartBuble: {
    backgroundColor: "#ff6534",
    justifyContent: "center",
    alignItems: "center",
    textAlign: "center",
    height: 15,
    width: 15,
    lineHeight: 15,
    fontSize: 10,
    borderRadius: 50,
    color: "#fff",
    fontSize:8
  },
  topContainer: {
    flex: 1,
    flexDirection: "row",
    backgroundColor: "white",
    borderBottomLeftRadius: 200,
    justifyContent: "flex-end",
    alignItems: "center",
    padding: 0,
    height: 230,
  },
  productImage: {
    width: "90%",
    height: "90%",
  },
  productDetailsContainer: {
    marginLeft: 10,
    justifyContent: "center",
  },
  productPrice: {
    fontSize: 18,
    color: "green",
  },
  centerContainer: {
    flex: 3,
    paddingTop: 20,
    paddingRight: 20,
    paddingLeft: 20,
  },
  productNameWrapper: {
    flexDirection: "row",
    justifyContent: "space-between",
  },
  productCategory: {
    fontSize: 36,
  },
  productName: {
    fontWeight: "bold",
    fontSize: 34,
  },
  descriptionWrapper: {
    marginTop: 20,
    height: 100,
  },
  description: {
    fontSize: 18,
  },
  varietyItemWrapper: {
    marginTop: 10,
    borderColor: "#ccc",
    borderRadius: 11,
    borderWidth: 1,
    minWidth: 80,
    height: 35,
    marginRight: 15,
    justifyContent: "center",
    alignItems: "center",
    paddingLeft: 15,
    paddingRight: 15,
  },
  varietyItemWrapperActive: {
    marginTop: 10,
    borderColor: "#ccc",
    borderRadius: 11,
    borderWidth: 1,
    minWidth: 80,
    height: 35,
    marginRight: 15,
    justifyContent: "center",
    alignItems: "center",
    paddingLeft: 15,
    paddingRight: 15,
    backgroundColor: "#ff6534",
  },
  varietyItemWrapperTxt: {
    color: "#666",
  },
  varietyItemWrapperTxtActive: {
    color: "white",
  },
  relatedProductsWrapper: {
    marginTop: -10,
  },
  relatedProductsHeader: {
    fontWeight: "bold",
  },
  relatedItemImgWrapper: {
    marginTop: 10,
    borderColor: "#ccc",
    borderRadius: 15,
    borderWidth: 2,
    padding: 15,
    marginRight: 15,
  },
  bottomContainer: {
    flex: 0.5,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    paddingTop: 15,
    paddingLeft: 20,
    paddingRight: 20,
    paddingBottom: 15,
  },
  quantityContainer: {
    marginTop: 45,
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
  },
  quantityButtonMinusText: {
    borderRadius: 10,
    backgroundColor: "green",
    width: 40,
    height: 40,
    justifyContent: "center",
    alignItems: "center",
  },
  quantityButtonPlusText: {
    borderRadius: 10,
    backgroundColor: "green",
    width: 40,
    height: 40,
    justifyContent: "center",
    alignItems: "center",
  },
  totalAmountWrapper: {
    flex: 0.6,
  },
  totalAmountHeader: {
    fontSize: 18,
    fontWeight: "bold",
  },
  totalAmount: {
    fontSize: 18,
    fontWeight: "bold",
  },
  currencyWrapper: {
    flexDirection: "row",
  },
  currency: {
    fontWeight: "bold",
    fontSize: 18,
    color: "green",
  },
  addToCartButtonWrapper: {
    flex: 1,
  },
  addToCartButton: {
    flex: 1,
    backgroundColor: "#ff6534",
    padding: 14,
    alignItems: "center",
    borderRadius: 18,
  },
  addToCartButtonText: {
    color: "white",
    fontWeight: "bold",
    fontSize: 18,
  },
  addedToCartButton: {
    flex: 1,
    padding: 14,
    alignItems: "center",
    borderRadius: 18,
    backgroundColor: "#36bb8a",
  },
});

export default AddToCartScreen;
