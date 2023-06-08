import AsyncStorage from "@react-native-async-storage/async-storage";
import { Picker } from "@react-native-picker/picker";
import React, { useEffect, useState } from "react";
import {
  ActivityIndicator,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";
import { FetchData } from "../../../components/api/FetchData";
import { PostData } from "../../../components/api/PostData";
import ButtonPrimary from "../../../components/common/ButtonPrimary";
import FailureMsg from "../../../components/common/FailureMsg";
import { BaseMobileUrl } from "../../../components/settings/BaseMobileUrl";
import { BaseUrl } from "../../../components/settings/BaseUrl";

function RegisterScreen({ navigation, route }) {
  const [animating, setAnimating] = useState(false);
  const [phone, setPhone] = useState("");
  const [fullname, setFullname] = useState("");
  const [regions, setRegions] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [selectedRegion, setSelectedRegion] = useState();
  const [selectedRegionId, setSelectedRegionId] = useState();
  const [selectedDistrict, setSelectedDistrict] = useState();
  const [messageVisible, setMessageVisible] = useState(false);
  const [msg, setMsg] = useState("");
  const [acceptBtnTxt, setAcceptBtnTxt] = useState("")
  const [regionIndex, setRegionIndex] = useState(0);
  const { isFromHomeScreen } = route.params;

  useEffect(() => {
    setAnimating(true);
    FetchData(BaseMobileUrl(`regions-districts`))
      .then((response) => {
        setRegions(response);
        setSelectedRegion(response[1]);
        setRegionIndex(1);
        setAnimating(false);
      })
      .catch((err) => {
        setAnimating(false);
        console.log(err);
      });
  }, []);

  useEffect(() => {
    if (regions.length > 0) {
      setDistricts(regions[regionIndex].districts);
      setSelectedDistrict(regions[regionIndex].districts[0]);
    }
  }, [regionIndex]);

  const registerUser = () => {
    let data = {
      name: fullname,
      phone: phone,
      campaign_id: 30,
      region_id: selectedRegion.id,
      role_id: 6
    };

    if (!data.name || !data.phone) {
      setMsg("All fields are required.");
      setMessageVisible(true);
      return;
    }

    setAnimating(true);

    PostData(BaseMobileUrl("user"), data)
      .then((response) => {
        if (response) {
          setMsg(
            "Congratulation for joining us, press continue to get started"
          );
          setMessageVisible(true);
          setAcceptBtnTxt("Continue")
        } else {
          setMessageVisible(true);
          setMsg(
            "Phone number exist, try another number or login if you are a member"
          );
        }

        setAnimating(false);
      })
      .catch((err) => {
        setAnimating(false);
      });
  };

  const handleCloseMsg = () => {
    setMessageVisible(false);
    //log user in
    logUserIn()

  };

  const logUserIn = () => {
    //TODO:input validation from chatgpt
    setAnimating(true)
    PostData(BaseUrl("login"), { phone:phone, password:"123456"})
      .then((response) => {
        AsyncStorage.setItem("auth_token", response.token);
        AsyncStorage.setItem("user", JSON.stringify(response.user));
        setAnimating(false)

        if (isFromHomeScreen) {
            //check if user is from home
            //if yes redirect back to home screen after loging
            //esle redirect to checkout screen
            navigation.navigate("Home");
          } else {
            navigation.navigate("Checkout");
          }

      })
      .catch((err) => {
        setAnimating(false)
        console.log(err);
      });
  };

  const onRegionChange = (item, index) => {
    setDistricts(item.districts);
    setSelectedRegion(item);
    console.log(item);
  };

  const onDistrictChange = (item) => {
    // console.log(item.name);
    setSelectedDistrict(item);
  };

  return (
    <View style={styles.container}>
      {animating && (
        <ActivityIndicator
          animating={animating}
          color="white"
          size="large"
          style={styles.activityIndicator}
        />
      )}
      <FailureMsg
        message={msg}
        visible={messageVisible}
        onClose={handleCloseMsg}
        acceptBtnTxt={acceptBtnTxt}
      />
      <Text style={styles.title}>Welcome to Fresh</Text>
      <Text>Fill the form bellow to join us</Text>
      <View style={{ marginTop: 20, width: "80%" }}>
        <TextInput
          style={styles.input}
          placeholder="Fullname"
          value={fullname}
          onChangeText={(text) => setFullname(text)}
        />
        <TextInput
          style={styles.input}
          placeholder="Phone number"
          value={phone}
          onChangeText={(text) => setPhone(text)}
        />
        <Text style={styles.label}>Select Region:</Text>
        <Picker
          style={styles.input}
          selectedValue={selectedRegion}
          onValueChange={(itemValue, itemIndex) => {
            onRegionChange(itemValue, itemIndex);
            setRegionIndex(1);
          }}
        >
          {regions &&
            regions.map((region) => (
              <Picker.Item key={region.id} label={region.name} value={region} />
            ))}
        </Picker>

        <Text style={styles.label}>Select District:</Text>
        <Picker
          style={styles.input}
          selectedValue={selectedDistrict}
          onValueChange={(itemValue, itemIndex) => onDistrictChange(itemValue)}
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
        <ButtonPrimary
          style={{ width: "100%", marginTop: 0 }}
          navigation={navigation}
          linkTo={"Home"}
          btnTxt={"Join Us"}
          flag={"fetchData"}
          fetchApiData={registerUser}
        />
      </View>

      <View style={styles.registerLinkWrapper}>
        <Text style={styles.registerLinkTitle}>If you have an account</Text>
        <TouchableOpacity
          onPress={() =>
            navigation.navigate("Login", { isFromHomeScreen: false })
          }
        >
          <Text style={styles.registerLink}>Login</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: "#fff",
  },
  activityIndicator: {
    position: "absolute",
    width: "100%",
    backgroundColor: "rgba(52, 52, 52, 0.8)",
    zIndex: 99,
    height: "100%",
  },
  title: {
    fontSize: 30,
    marginBottom: 20,
  },
  input: {
    width: "100%",
    height: 50,
    borderColor: "#ddd",
    borderWidth: 1,
    padding: 15,
    borderRadius: 10,
    marginBottom: 30,
    backgroundColor: "#eee",
    fontSize: 18,
  },
  registerLinkWrapper: {
    flexDirection: "row",
    marginTop: 20,
  },
  registerLinkTitle: {},
  registerLink: {
    color: "blue",
    fontSize: 16,
    marginLeft: 6,
  },
});
export default RegisterScreen;
