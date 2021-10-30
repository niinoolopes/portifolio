import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';

import { StorageGlobal } from "./context/global";
import { RouterGlobal } from "./routes/routes-global";

ReactDOM.render(
  <React.StrictMode>
    <StorageGlobal>
      <RouterGlobal>
        <App />
      </RouterGlobal>
    </StorageGlobal>
  </React.StrictMode>,
  document.getElementById('root')
);