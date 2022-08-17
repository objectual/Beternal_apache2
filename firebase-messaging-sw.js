// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyDmlagHFn1yw5KcbXHuIfuuWsw2EcXTmwE",
  authDomain: "notification-test-a3f05.firebaseapp.com",
  projectId: "notification-test-a3f05",
  storageBucket: "notification-test-a3f05.appspot.com",
  messagingSenderId: "299026161686",
  appId: "1:299026161686:web:53bf04a964fb438be01537",
  measurementId: "G-RT6CHXQZTF"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);