import React from 'react';
import ReactDOM from 'react-dom';
import App from './App'
import { GlobalStorage } from './GlobalContext'


if (document.getElementById('app')) {
  ReactDOM.render(
    <GlobalStorage>
      <App />
    </GlobalStorage>
    , document.getElementById('app'));
}
