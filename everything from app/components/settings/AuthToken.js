import AsyncStorage from "@react-native-async-storage/async-storage";
export function AuthToken() {
  const getToken = async () => {
    // try {
    //   const value = await AsyncStorage.getItem("auth_token");
    //   if (value !== null) {
    //     console.log(value);
    //     return value
    //   }
    // } catch (e) {
    //   console.error("Failed to load count from AsyncStorage", e);
    // }
  };
  return getToken();
}
