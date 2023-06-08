import axios from "axios";
import { AuthToken } from "../settings/AuthToken";
import { BaseUrl } from "../settings/BaseUrl";
import AsyncStorage from "@react-native-async-storage/async-storage";

export function PostData(endpoint, submitedData) {
  const addData = async () => {
    try {
      const token = await AsyncStorage.getItem("auth_token");
      if (token !== null) {
        console.log("kkdkdkd");
        const headers = {
          Authorization: "Bearer " + token,
          "Content-Type": "application/json",
        };
        const { data } = await axios({
          url: endpoint,
          method: "post",
          headers: headers,
          data: submitedData,
        });

        return data;
      } else {
        const { data } = await axios({
          url: endpoint,
          method: "post",
          data: submitedData,
        });

        return data;
      }
    } catch (e) {
      // console.error("Failed to load count from AsyncStorage", e);
    }
    // console.log(AuthToken())
  };
  return addData();
}
