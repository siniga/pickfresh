import axios from 'axios';
import { AuthToken } from '../settings/AuthToken';
import { BaseUrl } from '../settings/BaseUrl';
import AsyncStorage from "@react-native-async-storage/async-storage";

export function  FetchData(endpoint) {
    const fetchData = async () => {
       try {
        const token = await AsyncStorage.getItem("auth_token");
        if (token !== null) {
          const headers = {
            Authorization: "Bearer " + token,
            "Content-Type": "application/json",
          };
          const { data } = await axios.get(endpoint, { headers });
          return data;
        }else{
          const { data } = await axios.get(endpoint);
          return data;
        }
      } catch (e) {
        alert("There might be a network problem, please check your connection")
       // console.error("Failed to load count from AsyncStorage", e);
      }

        
      };
      return fetchData();
    
}