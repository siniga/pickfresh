import { TouchableOpacity, Text, StyleSheet } from 'react-native';

const FloatingActionButton = ({ onPress }) => {
  return (
    <TouchableOpacity style={styles.actionButton} onPress={onPress}>
        <Text style={styles.actionButtonText}>+</Text>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  actionButton: {
    backgroundColor: '#f9c2ff',
    padding: 10,
    alignItems: 'center',
    justifyContent: 'center',
    width: 60,
    height: 60,
    borderRadius: 30,
    elevation: 5,
    position: 'absolute',
    bottom: 20,
    right: 20,
  },
  actionButtonText: {
    fontSize: 30,
    fontWeight: 'bold',
  },
});

export default FloatingActionButton;
