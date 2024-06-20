import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getDatabase, ref, onValue, set } from "firebase/database";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional

const firebaseConfig = {
  apiKey: "AIzaSyDtP66Oc3nbdzWtrOwX301eGQ5Dh_YKMqE",
  authDomain: "iwatch-e996c.firebaseapp.com",
  projectId: "iwatch-e996c",
  storageBucket: "iwatch-e996c.appspot.com",
  messagingSenderId: "588749122433",
  appId: "1:588749122433:web:f029f81a2103087dcc9680",
  measurementId: "G-QQ6EEMLKE7",
  databaseURL: 'https://iwatch-e996c-default-rtdb.europe-west1.firebasedatabase.app/'
};

const db = initializeApp(firebaseConfig);

const datab =  getDatabase()


export { datab };