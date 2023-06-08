export function user() {
    if (localStorage.getItem("user")) return JSON.parse(localStorage.getItem("user"));
  }
  
  