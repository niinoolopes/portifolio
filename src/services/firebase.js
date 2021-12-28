import { initializeApp } from 'firebase/app';
import { getFirestore } from "firebase/firestore";

const config = {
  apiKey: "AIzaSyAdtZSphQDJ9XDFVxlly00kDtSJte73S1k",
  authDomain: "n-portifolio.firebaseapp.com",
  projectId: "n-portifolio",
  storageBucket: "n-portifolio.appspot.com",
  messagingSenderId: "814783712535",
  appId: "1:814783712535:web:7f007ec43d30a25e52fb52",
  measurementId: "G-1Y25Y3LJQ2"
};

export const app  = initializeApp(config);
export const db = getFirestore();
export const auth = app