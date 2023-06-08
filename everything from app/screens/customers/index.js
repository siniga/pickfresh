import React from "react";
import { View, Text, StyleSheet } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

function CustomersScreen() {
  return (
    <SafeAreaView style={styles.safeContainer}>
      <View>
        <Text>Customers</Text>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeContainer: {
    flex: 1,
  },
});

export default CustomersScreen;
