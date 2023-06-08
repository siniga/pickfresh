import AsyncStorage from "@react-native-async-storage/async-storage";
import { Picker } from "@react-native-picker/picker";
import React, { useEffect, useState } from "react";
import {
  ActivityIndicator,
  Button,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";
import { FetchData } from "../../components/api/FetchData";
import { PostData } from "../../components/api/PostData";
import ButtonPrimary from "../../components/common/ButtonPrimary";
import ScreenHeader from "../../components/common/ScreenHeader";
import { BaseMobileUrl } from "../../components/settings/BaseMobileUrl";
import { BaseUrl } from "../../components/settings/BaseUrl";

function CheckoutScreen({ navigation }) {
  const [regions, setRegions] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [selectedRegion, setSelectedRegion] = useState();
  const [selectedDistrict, setSelectedDistrict] = useState();
  const [regionIndex, setRegionIndex] = useState(0);
  const [name, setName] = useState("");
  const [phone, setPhone] = useState("");
  const [address, setAddress] = useState("");
  const [deliveryOption, setDeliveryOption] = useState("delivery");
  const [dayOption, setDayOption] = useState("today");
  const [timeOption, setTimeOption] = useState("");
  const [user, setUser] = useState({})
  const [loggedCustomer, setLoggedCustomer] = useState({});
  const [animating, setAnimating] = useState(false);

  useEffect(() => {
    setAnimating(true)
    FetchData(BaseMobileUrl(`regions-districts`))
      .then((response) => {
        setRegions(response);
        setSelectedRegion(response[0].name);
        setAnimating(false)
      })
      .catch((err) => {
        setAnimating(false)
        console.log(err);
      });
  }, []);

  useEffect(() => {
    setAnimating(true)
    FetchData(BaseMobileUrl(`customer/user/${user.id}`))
      .then((response) => {
      setAddress(response.user_input_address)
        setAnimating(false)
      })
      .catch((err) => {
        setAnimating(false)
        console.log(err);
      });
  }, [selectedDistrict]);

  useEffect(() => {
    //check if user is logged in
    //if yes display their details to user
    //if no allow user to fill in the details
    try {
      AsyncStorage.getItem("user")
        .then((user) => {
          if (user != null) {
            let cachedUser = JSON.parse(user);
            setUser(cachedUser)
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
    if (regions.length > 0) {
      setDistricts(regions[1].districts);
      setSelectedDistrict(regions[1].districts[0]);
    }
  }, [regionIndex]);

  //TODO:move this to a helper/util hook/component
  const generateOrderNumber = ()=> {
    const randomNumber = Math.floor(Math.random() * 1000000); // Generate a random number between 0 and 999999
    const paddedNumber = randomNumber.toString().padStart(6, '0'); // Pad the number with leading zeros if necessary to make it 6 digits long
    const timestamp = Date.now().toString().slice(-6); // Get the last 6 digits of the current timestamp
    const orderNumber = `${paddedNumber}-${timestamp}`; // Combine the padded number and timestamp with a hyphen
    return orderNumber;
  }
  const handleCreate = () => {
    if (!user.name || !user.phone || !address) {
      return alert("All fields are required.");
    }

    if(!timeOption){
      return alert("Please select time")
    }

    let data = {
      name: user.name,
      phone: user.phone,
      user_input_address:address,
      device_time: "2023-02-20 23:11:01",
      created_date: "2023-02-20",
      lat: "",
      lng: "",
      location: "",
      user_id: user.id,
      district_id: selectedDistrict.id,
      customer_type_id: 6,
      campaign_id: 30,
    };

    setAnimating(true)
    PostData(BaseUrl("customer"), data)
      .then((response) => {
        console.log(response.customer);
        getCart(response.customer)
      })
      .catch((err) => {
        setAnimating(false)
        console.log(err);
      });

    //clear fields
    setName("");
    setPhone("");
    setAddress("");
  };

  const getCart = customer =>{
    try {
      AsyncStorage.getItem("cart_data")
        .then((cacheCart) => {
          if (cacheCart != null) {
             submitOrder(cacheCart, customer)
          }
        })
        .then((res) => {
          //do something else
        });
    } catch (e) {
      console.log("error");
      // error reading value
    }
   
  }

  const submitOrder = (cart, customer )=>{
    let data = {
      device_time: "2023-02-20 12:11:01",
      order_no:generateOrderNumber(),
      status:0,
      created_date:"2023-02-20",
      location:"",
      lng:"",
      lat:"",
      user_id:user.id,
      customer_id:customer.id,
      campaign_id: 30,
      delivery_option:deliveryOption,
      day_option:dayOption,
      time_option:timeOption,
      order_total_amount: JSON.parse(cart).reduce((count, item) => count + item.quantity, 0),
      carts: cart
    }
    
    //post order data
    PostData(BaseUrl("order"), data)
    .then((response) => {
      setAnimating(false)
      //TODO:navigate to a successfull msg screen or dialog
      //dont forget to add time of delivery
      AsyncStorage.removeItem('cart_data')
      navigation.navigate("Home")
      console.log(response);
    })
    .catch((err) => {
      setAnimating(false)
      console.log(err);
    });
  }
  const onBackPress = () => {
    navigation.navigate("Home");
  };

  const onRegionChange = (item, index) => {
    setDistricts(item.districts);
    setSelectedRegion(item);
  };

  const onDistrictChange = (item) => {
    // console.log(item.name);
    setSelectedDistrict(item);
  };

  return (
    <View style={styles.mainContainer}>
       {animating && (
        <ActivityIndicator
          animating={animating}
          color="white"
          size="large"
          style={styles.activityIndicator}
        />
      )}
      <ScreenHeader
        onBackPress={onBackPress}
        onViewComponent={""}
        header={"Checkout"}
        rightItem={""}
        isBackPress={true}
      />
      <ScrollView>
        <View style={styles.container}>
          {/* <View style={styles.topContainer}>
          <View style={styles.locationWrapper}>
            <Text style={styles.locationHder}>Location:</Text>
            <Text style={styles.locationText}>Mikocheni Kinondoni Street</Text>
          </View>
        </View> */}

          <View style={styles.topContainer}>
            <Text style={{ paddingBottom: 20, fontSize: 18 }}>
              {" "}
              Select time to deliver/pickup this order {console.log(deliveryOption)}
            </Text>
            <Picker
              style={styles.input}
              defaultValue={deliveryOption}
              selectedValue={deliveryOption}
              onValueChange={(itemValue, itemIndex) =>
                setDeliveryOption(itemValue)
              }
            >
              <Picker.Item kye={1} label="Delivery" value="delivery"  style={{fontSize:18}}/>
              <Picker.Item kye={2} label="Pickup" value="pickup"  style={{fontSize:18}}/>
            </Picker>
            <Picker
              style={styles.input}
              selectedValue={dayOption}
              onValueChange={(itemValue, itemIndex) =>
                setDayOption(itemValue)
              }
            >
              <Picker.Item kye={1} label="Today" value="today" style={{fontSize:18}} />
              <Picker.Item kye={2} label="Tomorrow" value="tomorrow"  style={{fontSize:18}}/>
              <Picker.Item kye={2} label="Everyday of the week" value="tomorrow"  style={{fontSize:18}}/>
            </Picker>
            <Picker
              style={styles.input}
              selectedValue={timeOption}
              onValueChange={(itemValue, itemIndex) =>
                setTimeOption(itemValue)
              }
            >
              <Picker.Item kye={1} label="Time" value=""  style={{fontSize:18}}/>
              <Picker.Item kye={2} label="8:30 am" value="08:30 am"  style={{fontSize:18}} />
              <Picker.Item kye={3} label="09:00 am" value="09:00 am" style={{fontSize:18}} />
              <Picker.Item kye={4} label="10:00 am" value="10:00 am"  style={{fontSize:18}}/>
              <Picker.Item kye={5} label="11:00 am" value="11:00 am"  style={{fontSize:18}}/>
              <Picker.Item kye={6} label="12:00 pm" value="12:00 pm"  style={{fontSize:18}}/>
              <Picker.Item kye={7} label="01:00 pm" value="01:00 pm"  style={{fontSize:18}}/>
              <Picker.Item kye={8} label="02:00 pm" value="02:00 pm"  style={{fontSize:18}}/>
              <Picker.Item kye={9} label="03:00 pm" value="03:00 pm"  style={{fontSize:18}}/>
              <Picker.Item kye={10} label="04:00 pm" value="04:00 pm"  style={{fontSize:18}} />
              <Picker.Item kye={11} label="05:00 pm" value="05:00 pm"  style={{fontSize:18}}/>
              <Picker.Item kye={12} label="06:00 pm" value="06:00 pm"  style={{fontSize:18}}/>

            </Picker>
          </View>
          <View style={styles.bottomContainer}>
            {/* <Text style={styles.label}>Name:</Text>
          <TextInput
            style={styles.input}
            value={name}
            placeholder="Enter your name"
            onChangeText={setName}
          /> */}

            {/* <Text style={styles.label}>Phone:</Text>
          <TextInput
            placeholder="Enter your phone"
            style={styles.input}
            value={phone}
            onChangeText={setPhone}
            keyboardType="numeric"
          /> */}
            <Text style={{ paddingBottom: 20, fontSize: 18 }}>
              {" "}
              Provide your location
            </Text>
            {/* <Text style={styles.label}>Select Region:</Text> */}
            <Picker
              style={{display:"none"}}
              selectedValue={selectedRegion}
              onValueChange={(itemValue, itemIndex) => {
                onRegionChange(itemValue, itemIndex);
                setRegionIndex(1);
              }}
            >
              {regions &&
                regions.map((region) => (
                  <Picker.Item
                    key={region.id}
                    label={region.name}
                    value={region}
                  />
                ))}
            </Picker>

            <Text style={styles.label}>Select District:</Text>
            <Picker
              style={styles.input}
              selectedValue={selectedDistrict}
              onValueChange={(itemValue, itemIndex) =>
                onDistrictChange(itemValue)
              }
            >
              {districts &&
                districts.map((district) => (
                  <Picker.Item
                    key={district.id}
                    label={district.name}
                    value={district}
                  />
                ))}
            </Picker>
            <Text style={styles.label}>Home Address:</Text>
            <TextInput
              placeholder="Enter your address"
              style={styles.input}
              value={address}
              onChangeText={setAddress}
            />

            <ButtonPrimary
              navigation={navigation}
              btnTxt={"Complete Order"}
              fetchApiData={handleCreate}
            />
          </View>
        </View>
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  mainContainer: {
    height: "100%",
  },
  container: {
    flex: 1,
    padding: 20,
  },
  activityIndicator:{
    position:"absolute",
    width:"100%",
    backgroundColor:"rgba(52, 52, 52, 0.8)",
    zIndex:99,
    height: "100%"
  },
  topContainer: {
    padding: 20,
    backgroundColor: "white",
    borderRadius: 15,
    borderWidth: 1,
    borderColor: "#ddd",
  },
  locationWrapper: {
    padding: 20,
    borderRadius: 15,
    borderWidth: 1,
    borderColor: "#ddd",
    flexDirection: "row",
    alignItems: "center",
  },
  locationHder: {
    fontSize: 18,
    fontWeight: "800",
  },
  locationText: {
    fontSize: 14,
    fontWeight: "600",
    marginLeft: 10,
  },
  bottomContainer: {
    marginTop: 20,
    padding: 20,
    backgroundColor: "white",
    borderRadius: 15,
    borderWidth: 1,
    borderColor: "#ddd",
  },
  label: {
    fontWeight: "bold",
    marginVertical: 5,
  },
  input: {
    borderColor: "#ddd",
    borderWidth: 1,
    padding: 10,
    borderRadius: 10,
    marginBottom: 30,
    backgroundColor: "#eee",
  },
  checkoutBtn: {
    marginTop: 20,
    backgroundColor: "#ff6534",
    alignItems: "center",
    justifyContent: "center",
    padding: 15,
    borderRadius: 20,
  },
  checkoutBtnTxt: {
    fontSize: 20,
    fontWeight: "700",
    color: "white",
  },
});

export default CheckoutScreen;
